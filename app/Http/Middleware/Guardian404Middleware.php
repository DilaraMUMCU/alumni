<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Guardian404Middleware (404 Guardian)
 *
 * Intercepts all 404 Not Found errors across the application and returns
 * a structured, informative response containing a specific 'reason'.
 */
class Guardian404Middleware
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
        } catch (NotFoundHttpException $e) {
            $reason = $e->getMessage() ?: $this->resolveRouteReason($request);
            return self::render404($request, $reason);
        } catch (ModelNotFoundException $e) {
            $model = class_basename($e->getModel());
            $ids = implode(', ', (array) $e->getIds());
            $reason = "The requested {$model} record" . ($ids ? " with ID [{$ids}]" : "") . " was not found in the database.";
            return self::render404($request, $reason);
        }

        // Intercept existing 404 responses returned by controllers or abort(404)
        if ($response->getStatusCode() === 404) {
            return $this->enrich404Response($request, $response);
        }

        return $response;
    }

    /**
     * Determine a descriptive reason for an unmatched route based on the request URI.
     */
    public function resolveRouteReason(Request $request): string
    {
        $path = '/' . ltrim($request->path(), '/');
        $method = strtoupper($request->method());

        $segments = explode('/', trim($path, '/'));
        $firstSegment = $segments[0] ?? '';

        if ($firstSegment === 'api') {
            return "The API endpoint '{$method} {$path}' does not exist. Please check the interactive documentation at /api/swagger for valid endpoints.";
        }

        return "The requested page '{$method} {$path}' was not found on this server. Please verify the URL or return to the main dashboard.";
    }

    /**
     * Enrich an existing 404 response with the 'reason' property.
     */
    protected function enrich404Response(Request $request, Response $response): Response
    {
        $existingReason = null;
        $content = $response->getContent();

        if ($content) {
            $json = json_decode($content, true);
            if (is_array($json)) {
                $existingReason = $json['reason'] ?? $json['message'] ?? $json['error'] ?? null;
            }
        }

        $reason = $existingReason ?: $this->resolveRouteReason($request);

        return self::render404($request, $reason);
    }

    /**
     * Render a structured 404 response with a clear reason.
     */
    public static function render404(Request $request, string $reason): Response
    {
        $path = '/' . ltrim($request->path(), '/');
        $method = strtoupper($request->method());
        $timestamp = date('Y-m-d H:i:s');

        // JSON response for API endpoints, AJAX, or clients expecting JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success'   => false,
                'status'    => 404,
                'error'     => 'Not Found',
                'reason'    => $reason,
                'path'      => $path,
                'method'    => $method,
                'timestamp' => $timestamp,
                'guardian'  => '404 Guardian Active',
            ], 404, [
                'Content-Type'   => 'application/json; charset=utf-8',
                'X-Guardian-404' => 'Protected',
            ]);
        }

        // Web / HTML response for browsers
        if (view()->exists('errors.404')) {
            return response()->view('errors.404', [
                'reason'    => $reason,
                'path'      => $path,
                'method'    => $method,
                'timestamp' => $timestamp,
            ], 404);
        }

        return response(self::fallbackHtml($path, $method, $reason, $timestamp), 404, [
            'Content-Type'   => 'text/html; charset=utf-8',
            'X-Guardian-404' => 'Protected',
        ]);
    }

    /**
     * Fallback HTML for browser requests.
     */
    protected static function fallbackHtml(string $path, string $method, string $reason, string $timestamp): string
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Sayfa Bulunamadı | 404 Guardian</title>
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
        <div class="guardian-badge">🛡️ 404 Guardian Middleware Active</div>
        <h1>404</h1>
        <h2>Kaynak veya Sayfa Bulunamadı</h2>

        <div class="reason-box">
            <strong>Bulunamama Sebebi (Reason):</strong>
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
