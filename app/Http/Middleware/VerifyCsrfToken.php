<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // No exceptions needed - all routes should verify CSRF
    ];
    
    /**
     * Determine if the request has a valid CSRF token.
     * Override to add better error handling.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasValidCsrfToken($request)
    {
        try {
            return parent::hasValidCsrfToken($request);
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                abort(419, 'CSRF token mismatch. Please refresh the page and try again.');
            }
            throw $e;
        }
    }
}
