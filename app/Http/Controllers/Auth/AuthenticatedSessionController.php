<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    $user = Auth::user();

        // Garbage Collector
if ($user->role === 'garbage_collector' && $user->status === 'approved') {
    return redirect()->route('collector.dashboard');
}

    // LGU Admin
    if ($user->role === 'lgu_admin') {
        return redirect()->route('dashboard');
    }

    // Approved Resident
    if ($user->role === 'resident' && $user->status === 'approved') {
        return redirect()->route('resident.dashboard');
    }

    // Pending / Rejected Resident
    if ($user->role === 'resident') {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'status',
                'Your account is still pending LGU verification.'
            );
    }

    // Fallback
    return redirect()->route('dashboard');
}
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
