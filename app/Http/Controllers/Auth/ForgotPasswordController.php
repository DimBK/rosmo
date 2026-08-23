<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ResetPasswordTokenMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar dalam sistem.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate 6-digit numeric token
        $token = rand(100000, 999999);

        // Save token to password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );

        // Send email to user
        Mail::to($request->email)->send(new ResetPasswordTokenMail($token, $user));

        return redirect()->route('password.reset', ['email' => $request->email])
            ->with('status', 'Kode token reset password telah dikirim ke email Anda.');
    }

    public function showResetForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.reset-password', compact('email'));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required|numeric',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
        ]);

        // Retrieve the token record
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return back()->withErrors(['token' => 'Permintaan reset password tidak valid.'])->withInput();
        }

        // Validate token matching
        if ($record->token !== $request->token) {
            return back()->withErrors(['token' => 'Kode token yang Anda masukkan salah.'])->withInput();
        }

        // Validate token expiration (15 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['token' => 'Kode token telah kedaluwarsa. Silakan minta kode baru.'])->withInput();
        }

        // Update user's password
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Create activity log
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Reset Password',
            'ip_address' => $request->ip(),
        ]);

        // Delete the token record
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password Anda berhasil diperbarui! Silakan masuk.');
    }
}
