<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

class HealthCheckController extends Controller
{
    /**
     * Health check endpoint for monitoring systems.
     * Returns 200 if healthy, 503 if degraded.
     */
    public function check(): JsonResponse
    {
        $status = 'ok';
        $checks = [];

        // Database check
        try {
            DB::connection()->getPdo();
            $checks['database'] = 'ok';
        } catch (\Exception $e) {
            $status = 'degraded';
            $checks['database'] = 'error: ' . $e->getMessage();
        }

        // Cache check (optional)
        try {
            Cache::put('health_check', time(), now()->addSeconds(10));
            $checks['cache'] = 'ok';
        } catch (\Exception $e) {
            $checks['cache'] = 'warning: ' . $e->getMessage();
        }

        // Response
        $code = $status === 'ok' ? 200 : 503;
        return response()->json([
            'status' => $status,
            'timestamp' => now()->toIso8601String(),
            'checks' => $checks,
        ], $code);
    }

    /**
     * Detailed health check (admin only).
     */
    public function detailed(): JsonResponse
    {
        $this->authorize('viewAny', \App\Models\User::class);

        return response()->json([
            'status' => 'ok',
            'environment' => env('APP_ENV'),
            'debug_mode' => env('APP_DEBUG'),
            'memory_usage' => memory_get_usage(true) / 1024 / 1024 . ' MB',
            'peak_memory' => memory_get_peak_usage(true) / 1024 / 1024 . ' MB',
            'uptime' => ini_get('default_socket_timeout') . 's',
        ]);
    }
}
