<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
        ]);

        // Without this, $request->ip() returns your load balancer/CDN's IP for every
        // visitor once deployed behind one — which silently breaks IP-based rate
        // limiting (all visitors share one throttle bucket) and degrades Meta
        // Conversions API match quality (wrong client IP sent for every lead).
        // Opt-in only, via .env, so a direct-to-server deployment (no proxy in front)
        // is never tricked by a spoofed X-Forwarded-For header from a random client.
        //
        // env() (not config()) is deliberate and correct here: this closure runs
        // during application bootstrapping, before the config/container system is
        // available — config('app.trusted_proxies') fatals with "Target class
        // [config] does not exist" at this point in the lifecycle.
        if ($trustedProxies = env('TRUSTED_PROXIES')) {
            $middleware->trustProxies(
                at: $trustedProxies === '*' ? '*' : array_map('trim', explode(',', $trustedProxies)),
            );
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
