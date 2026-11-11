<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Guardian5xxMiddleware (5xx Guardian)
 *
 * Intercepts all 5xx Server Errors (500, 501, 502, 503, 504) and uncaught Throwables,
 * returning a structured, informative response with a specific 'reason'.
 */
class Guardian5xxMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $response = $next($request);
        } catch (Throwable $e) {
            // Let 4xx client errors pass through to 404 Guardian / client handlers
            if ($e instanceof HttpExceptionInterface && $e->getStatusCode() < 500) {
                throw $e;
            }

            $statusCode = ($e instanceof HttpExceptionInterface) ? $e->getStatusCode() : 500;
            $reason = $this->resolveExceptionReason($e);

            return self::render5xx($request, $reason, $statusCode, $e);
        }

        // Intercept existing 5xx responses returned by controllers
        if ($response->getStatusCode() >= 500 && $response->getStatusCode() <= 599) {
            return $this->enrich5xxResponse($request, $response);
        }

        return $response;
    }

    /**
     * Resolve a descriptive reason from a Throwable exception.
     */
    public function resolveExceptionReason(Throwable $e): string
    {
        $message = trim($e->getMessage());

        if (config('app.debug')) {
            return !empty($message)
                ? $message
                : "Internal server error: " . class_basename($e) . " was thrown without a message.";
        }

        // Production-safe error explanation
        if ($e instanceof \Illuminate\Database\QueryException) {
            return "A database operation error occurred while processing your request. Please try again later or contact system administration.";
        }

        return !empty($message)
            ? $message
            : "An unexpected internal server error occurred while processing your request. Please check server logs for details.";
    }

    /**
     * Enrich an existing 5xx response with the 'reason' property.
     */
    protected function enrich5xxResponse(Request $request, Response $response): Response
    {
        $statusCode = $response->getStatusCode();
        $existingReason = null;
        $content = $response->getContent();

        if ($content) {
            $json = json_decode($content, true);
            if (is_array($json)) {
                $existingReason = $json['reason'] ?? $json['message'] ?? $json['error'] ?? null;
            }
        }

        $reason = $existingReason ?: $this->defaultStatusReason($statusCode);

        return self::render5xx($request, $reason, $statusCode);
    }

    /**
     * Get default descriptive reason by 5xx HTTP status code.
     */
    protected function defaultStatusReason(int $statusCode): string
    {
        return match ($statusCode) {
            500 => "Internal Server Error: The server encountered an unexpected condition that prevented it from fulfilling the request.",
            501 => "Not Implemented: The server does not support the functionality required to fulfill the request.",
            502 => "Bad Gateway: The server received an invalid response from an upstream server.",
            503 => "Service Unavailable: The server is currently unable to handle the request due to maintenance or overload.",
            504 => "Gateway Timeout: The upstream server failed to send a timely response.",
            default => "A server error occurred (HTTP {$statusCode}).",
        };
    }

    /**
     * Render a structured 5xx response with a clear reason for API/JSON and HTML clients.
     */
    public static function render5xx(Request $request, string $reason, int $statusCode = 500, ?Throwable $exception = null): Response
    {
        $path = '/' . ltrim($request->path(), '/');
        $method = strtoupper($request->method());
        $timestamp = date('Y-m-d H:i:s');

        // Log to logs/error.logs
        ErrorLogWriter::write('5XX_SERVER_ERROR', $statusCode, $method, $path, $reason, $exception);
        $request->attributes->set('logged_to_error_log', true);

        // JSON response for API endpoints, AJAX, or clients expecting JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            $payload = [
                'success'   => false,
                'status'    => $statusCode,
                'error'     => 'Server Error',
                'reason'    => $reason,
                'path'      => $path,
                'method'    => $method,
                'timestamp' => $timestamp,
                'guardian'  => '5xx Guardian Active',
            ];

            if (config('app.debug') && $exception) {
                $payload['exception'] = class_basename($exception);
                $payload['file'] = $exception->getFile();
                $payload['line'] = $exception->getLine();
            }

            return response()->json($payload, $statusCode, [
                'Content-Type'   => 'application/json; charset=utf-8',
                'X-Guardian-5xx' => 'Protected',
            ]);
        }

        // Web / HTML response for browsers
        if (view()->exists("errors.{$statusCode}")) {
            return response()->view("errors.{$statusCode}", [
                'reason'     => $reason,
                'statusCode' => $statusCode,
                'path'       => $path,
                'method'     => $method,
                'timestamp'  => $timestamp,
            ], $statusCode);
        }

        return response(self::fallbackHtml($path, $method, $reason, $statusCode, $timestamp), $statusCode, [
            'Content-Type'   => 'text/html; charset=utf-8',
            'X-Guardian-5xx' => 'Protected',
        ]);
    }

    /**
     * Fallback HTML for browser requests.
     */
    protected static function fallbackHtml(string $path, string $method, string $reason, int $statusCode, string $timestamp): string
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$statusCode} - Sunucu Hatası | 5xx Guardian</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .card { max-width: 650px; width: 100%; background: rgba(30, 41, 59, 0.9); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 20px; padding: 36px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); backdrop-filter: blur(14px); text-align: center; }
        .guardian-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); color: #f87171; font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 9999px; text-transform: uppercase; margin-bottom: 20px; }
        h1 { font-size: 64px; font-weight: 900; color: #ef4444; letter-spacing: -2px; margin-bottom: 8px; }
        h2 { font-size: 22px; color: #ffffff; margin-bottom: 16px; }
        .reason-box { background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255, 255, 255, 0.1); border-left: 4px solid #ef4444; border-radius: 10px; padding: 16px 20px; text-align: left; margin: 20px 0; font-size: 14px; color: #e2e8f0; line-height: 1.6; }
        .reason-box strong { color: #f87171; display: block; font-size: 12px; text-transform: uppercase; margin-bottom: 4px; }
        .meta { display: flex; justify-content: space-between; font-size: 12px; color: #94a3b8; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 14px; margin-top: 20px; flex-wrap: wrap; gap: 8px; }
        .actions { display: flex; gap: 12px; justify-content: center; margin-top: 24px; flex-wrap: wrap; }
        .btn { padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
        .btn-primary { background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%); color: #ffffff; }
        .btn-secondary { background: rgba(255,255,255,0.08); color: #cbd5e1; }
        .btn:hover { opacity: 0.9; transform: translateY(-1px); }
    </style>
</head>
<body>
    <div class="card">
        <div class="guardian-badge">🛡️ 5xx Guardian Middleware Active</div>
        <h1>{$statusCode}</h1>
        <h2>Sunucu Hatası Oluştu</h2>

        <div class="reason-box">
            <strong>Hata Sebebi (Reason):</strong>
            {$reason}
        </div>

        <div class="meta">
            <span><strong>İstek:</strong> {$method} {$path}</span>
            <span><strong>Zaman:</strong> {$timestamp}</span>
        </div>

        <div class="actions">
            <a href="/" class="btn btn-primary">🏠 Ana Sayfa</a>
            <a href="/users" class="btn btn-secondary">👥 Kullanıcılar</a>
            <a href="/job-postings" class="btn btn-secondary">💼 İlanlar</a>
            <a href="/api/swagger" class="btn btn-secondary" target="_blank">📜 Swagger API</a>
        </div>
    </div>
</body>
</html>
HTML;
    }
}
