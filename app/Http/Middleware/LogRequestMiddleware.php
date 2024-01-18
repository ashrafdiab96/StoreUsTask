<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Request from IP address: ' . $request->ip() . ' at ' . now());
        $ipAddress = $request->ip();
        $requestedAt = now();
        DB::table('request_logs')->insert([
            'ip_address' => $ipAddress,
            'requested_at' => $requestedAt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return $next($request);
    }
}
