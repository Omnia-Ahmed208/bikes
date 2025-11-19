<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuardMiddleware
{
    public function handle(Request $request, Closure $next, $guard)
    {
        // $user = $request->user();
        $user = Auth::guard($guard)->user();

        if (!$user) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => __('trans.alert.error.logged_first') ?? 'Unauthorized',
                ], 401);
            }

            return redirect()->route('' . $guard . '.login');
        }

        // Check if user is the correct type
        $userType = class_basename(get_class($user));

        if (strtolower($userType) !== strtolower($guard)) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => "Access denied. Please log in as the correct user type ($guard).",
                ], 403);
            }

            return redirect()->route('' . $guard . '.login');
        }

        return $next($request);
    }
}
