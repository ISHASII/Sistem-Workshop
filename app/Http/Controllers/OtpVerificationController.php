<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OtpVerificationController extends Controller
{
    public function show()
    {
        if (! session('otp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.otp-verification');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'digits:6'],
        ]);

        $userId = session('otp_user_id');
        if (! $userId) {
            return redirect()->route('login')->withErrors(['otp_code' => 'Sesi verifikasi telah berakhir. Silakan login kembali.']);
        }

        $otp = Otp::where('user_id', $userId)
            ->where('otp_code', $request->otp_code)
            ->where('is_used', false)
            ->where('expired_at', '>', now())
            ->latest()
            ->first();

        if (! $otp) {
            return back()->withErrors(['otp_code' => 'Kode OTP tidak valid atau telah kedaluwarsa.']);
        }

        $otp->is_used = true;
        $otp->save();

        Auth::loginUsingId($userId);
        session()->forget('otp_user_id');
        $request->session()->regenerate();

    return redirect()->intended(route('dashboard'));
    }
}
