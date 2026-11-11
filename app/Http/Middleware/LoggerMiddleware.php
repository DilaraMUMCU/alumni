<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoggerMiddleware
{
    /**
     * Handle an incoming request and log its execution details to the terminal.
     *
     * Format: time method route res. duration
     * Example: 10:20:30 POST /user 201 18ms
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = defined('LARAVEL_START') ? LARAVEL_START : microtime(true);

        $response = $next($request);

        $durationMs = max(1, (int) round((microtime(true) - $startTime) * 1000));

        $time   = date('H:i:s');
        $method = strtoupper($request->method());
        $route  = '/' . ltrim($request->path(), '/');
        $status = $response->getStatusCode();

        $logRow = sprintf('%s %s %s %s %dms', $time, $method, $route, $status, $durationMs);

        $this->writeToTerminal($logRow, $status);

        return $response;
    }

    /**
     * Write the log row directly to terminal / console streams.
     */
    protected function writeToTerminal(string $message, int $status): void
    {
        // ANSI color formatting for terminal visibility
        $color = match (true) {
            $status >= 500 => "\033[31m", // Red
            $status >= 400 => "\033[33m", // Yellow
            $status >= 300 => "\033[36m", // Cyan
            $status >= 200 => "\033[32m", // Green
            default        => "\033[0m",
        };
        $reset = "\033[0m";

        $coloredMessage = sprintf("%s%s%s%s", $color, $message, $reset, PHP_EOL);

        // 1. Primary: output to STDOUT (clean single line in terminal & Docker logs)
        $stdout = @fopen('php://stdout', 'w');
        if ($stdout) {
            @fwrite($stdout, $coloredMessage);
            @fclose($stdout);
            return;
        }

        // 2. Secondary fallback: output to STDERR
        $stderr = @fopen('php://stderr', 'w');
        if ($stderr) {
            @fwrite($stderr, $coloredMessage);
            @fclose($stderr);
            return;
        }

        // 3. Fallback: system error_log
        @error_log($message);
    }
}
