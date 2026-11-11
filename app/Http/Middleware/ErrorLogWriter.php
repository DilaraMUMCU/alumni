<?php

namespace App\Http\Middleware;

use Throwable;

/**
 * ErrorLogWriter
 *
 * Dedicated helper to persist middleware error logs into logs/error.logs
 * for persistent tracking and future debugging.
 */
class ErrorLogWriter
{
    /**
     * File path to the error log file.
     */
    public static function logPath(): string
    {
        return base_path('logs/error.logs');
    }

    /**
     * Append an error record to logs/error.logs.
     *
     * @param string $type Classification (e.g. '404_NOT_FOUND', '5XX_SERVER_ERROR', 'REQUEST_ERROR')
     * @param int $status HTTP status code (e.g. 404, 500)
     * @param string $method HTTP method (GET, POST, etc.)
     * @param string $path Requested URI path
     * @param string $reason Descriptive reason for the error
     * @param Throwable|null $exception Underlying exception if available
     * @param int $durationMs Request execution time in milliseconds
     */
    public static function write(
        string $type,
        int $status,
        string $method,
        string $path,
        string $reason,
        ?Throwable $exception = null,
        int $durationMs = 0
    ): void {
        // Prevent duplicate logging for the same request
        if (function_exists('request') && app()->bound('request')) {
            $req = request();
            if ($req && $req->attributes->get('logged_to_error_log')) {
                return;
            }
            if ($req) {
                $req->attributes->set('logged_to_error_log', true);
            }
        }

        $logDir = base_path('logs');
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0777, true);
        }

        $logFile = self::logPath();
        $timestamp = date('Y-m-d H:i:s');
        $ip = request()->ip() ?? '127.0.0.1';
        $durationStr = $durationMs > 0 ? " | Duration: {$durationMs}ms" : "";

        $entry = sprintf("[%s] [%s %d] %s %s (IP: %s%s)\n", $timestamp, $type, $status, strtoupper($method), $path, $ip, $durationStr);
        $entry .= sprintf("  Reason : %s\n", $reason);

        if ($exception) {
            $entry .= sprintf("  Source : %s:%d\n", $exception->getFile(), $exception->getLine());
            $entry .= sprintf("  Class  : %s\n", get_class($exception));
        }

        $entry .= "--------------------------------------------------------------------------------\n";

        @file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);
    }
}
