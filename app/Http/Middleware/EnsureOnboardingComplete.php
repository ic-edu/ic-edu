<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // Jika onboarding belum selesai dan bukan sedang di route onboarding
        if (
            !$user->hasCompletedOnboarding() &&
            !$request->routeIs('onboarding.*')
        ) {
            return redirect()->route('onboarding.index');
        }

        // Jika onboarding sudah selesai tapi masih akses route onboarding
        if (
            $user->hasCompletedOnboarding() &&
            $request->routeIs('onboarding.*')
        ) {
            return redirect()->route('test_taker.dashboard');
        }

        return $next($request);
    }
}
