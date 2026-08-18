<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('admin')->user();

        if (! $user) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login to continue.');
        }

        // only admin-side roles can access admin panel
        if (! in_array($user->role->slug, [
            'super_admin',
            'admin',
            'teacher',
        ])) {

            Auth::guard('admin')->logout();

            return redirect()->route('admin.login')
                ->with('error', 'You are not authorized to access admin panel.');
        }

        // optional: inactive users block
        if ((int) $user->status !== 1) {
            Auth::guard('admin')->logout();

            return redirect()->route('admin.login')
                ->with('error', 'Your account is inactive.');
        }

        return $next($request);
    }
}
