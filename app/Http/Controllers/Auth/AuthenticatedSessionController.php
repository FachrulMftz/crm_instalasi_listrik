<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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
    $key = $this->throttleKey($request);

    // 1️⃣ Cek apakah sedang diblokir
    if (RateLimiter::tooManyAttempts($key,2)) {
        $seconds = RateLimiter::availableIn($key);

        return back()->withErrors([
            'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik."
        ])->with('lockout', $seconds);
    }

    // 2️⃣ Coba login (SATU PINTU SAJA)
    if (!Auth::attempt($request->only('email', 'password'))) {

        // 3️⃣ Tambah attempt & lock 60 detik
        RateLimiter::hit($key, 60);

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ]);
    }

    // 4️⃣ Login sukses → reset counter
    RateLimiter::clear($key);

    $request->session()->regenerate();

    return redirect()->intended(RouteServiceProvider::HOME);
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

private function throttleKey(Request $request)
{
    return Str::lower($request->input('email')) . '|' . $request->ip();
}

}
