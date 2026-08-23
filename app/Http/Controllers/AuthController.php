<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        $this->refreshCaptcha();
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'captcha' => ['required', 'integer'],
        ]);

        if ($request->input('captcha') != session('captcha_answer')) {
            $this->refreshCaptcha();
            return back()->withErrors([
                'captcha' => 'Jawaban captcha salah. Silakan coba lagi.',
            ])->onlyInput('email');
        }

        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if ($user && !$user->is_active) {
            $this->refreshCaptcha();
            return back()->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Hubungi Super Admin.',
            ])->onlyInput('email');
        }

        $loginCredentials = [
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ];

        if (Auth::attempt($loginCredentials)) {
            $request->session()->regenerate();
            
            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Login',
                'ip_address' => $request->ip(),
            ]);

            session()->forget(['captcha_text', 'captcha_answer']);

            return redirect()->intended('/admin/dashboard');
        }

        $this->refreshCaptcha();

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function refreshCaptcha()
    {
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $operators = ['+', '-'];
        $operator = $operators[array_rand($operators)];
        
        if ($operator === '-') {
            if ($num1 < $num2) {
                $temp = $num1;
                $num1 = $num2;
                $num2 = $temp;
            }
            $answer = $num1 - $num2;
        } else {
            $answer = $num1 + $num2;
        }

        session(['captcha_text' => "$num1 $operator $num2", 'captcha_answer' => $answer]);

        if (request()->ajax()) {
            return response()->json(['captcha' => session('captcha_text')]);
        }
    }
}
