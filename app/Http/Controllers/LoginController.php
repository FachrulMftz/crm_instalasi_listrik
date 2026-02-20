<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $key = Str::lower($request->input('email')) . '|' . $request->ip();

    if (RateLimiter::tooManyAttempts($key, 2)) {
        $seconds = RateLimiter::availableIn($key);

        return back()
            ->withErrors(['email' => "Terlalu banyak percobaan login."])
            ->with('lockout', $seconds);
    }

    if (!Auth::attempt($request->only('email', 'password'))) {
        RateLimiter::hit($key, 60);

        $attempts  = RateLimiter::attempts($key);
        $remaining = max(1, 3 - $attempts);

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->with('remaining_attempts', $remaining);
    }

    RateLimiter::clear($key);

    $request->session()->regenerate();
    return redirect()->route('dashboard.redirect');
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}
