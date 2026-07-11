<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ReporterAuthController extends Controller
{
    public function showLogin()
    {
        return view('lapor.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('reporter')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/lapor-sdm/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('lapor.auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:reporters',
            'password' => 'required|string|min:8|confirmed',
            'whatsapp' => 'required|string|max:20',
            'type' => 'required|in:asn,non_asn',
            'privacy_policy' => 'accepted',
        ];

        if ($request->type === 'asn') {
            $rules['nip'] = 'required|string|size:18|unique:reporters';
        } else {
            $rules['nik'] = 'required|string|size:16|unique:reporters';
        }

        $validatedData = $request->validate($rules, [
            'nip.size' => 'NIP harus 18 digit.',
            'nik.size' => 'NIK harus 16 digit.',
            'privacy_policy.accepted' => 'Anda harus menyetujui Kebijakan Privasi.',
        ]);

        $reporter = Reporter::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'whatsapp' => $validatedData['whatsapp'],
            'type' => $validatedData['type'],
            'nip' => $request->type === 'asn' ? $validatedData['nip'] : null,
            'nik' => $request->type === 'non_asn' ? $validatedData['nik'] : null,
        ]);

        Auth::guard('reporter')->login($reporter);

        return redirect('/lapor-sdm/dashboard')->with('success', 'Registrasi berhasil.');
    }

    public function logout(Request $request)
    {
        Auth::guard('reporter')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/lapor-sdm/login');
    }
}
