<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateVendor
{
    public function handle(Request $request, Closure $next)
    {
        $vendor = Auth::guard('vendor')->user();

        if (! $vendor) {
            return redirect()->route('vendor.login');
        }

        // Suspended or banned vendors lose access immediately, not just at login
        if ($vendor->status !== 'active') {
            Auth::guard('vendor')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('vendor.login')
                ->with('error', 'Your account is not active. Please contact support.');
        }

        return $next($request);
    }
}
