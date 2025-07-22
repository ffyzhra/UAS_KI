<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Prevent Clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');

        // Prevent XSS attacks
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Disable content type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Content Security Policy (CSP)
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'");

        // Force HTTPS
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        return $response;
    }
}