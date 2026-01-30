<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitCoupon
{
    /**
     * Handle an incoming request.
     *
     * Rate limit coupon/promo code applications to prevent brute force attacks.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $this->resolveRequestKey($request);
        
        // Allow 10 coupon/promo attempts per minute
        $maxAttempts = 10;
        $decayMinutes = 1;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Too many code attempts. Please try again in ' . $seconds . ' seconds.',
                    'retry_after' => $seconds
                ], 429);
            }

            return redirect()->back()
                ->with('error', 'Too many code attempts. Please wait ' . $seconds . ' seconds before trying again.');
        }

        RateLimiter::hit($key, $decayMinutes * 60);

        return $next($request);
    }

    /**
     * Resolve the request key for rate limiting.
     */
    protected function resolveRequestKey(Request $request): string
    {
        if (Auth::check()) {
            return 'coupon:' . Auth::id();
        }

        return 'coupon:' . $request->ip();
    }
}
