<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($id, $token)
    {
        $user = User::find($id);

        if (!$user || $user->email_verification_token !== $token) {
            return redirect()->route('login')->with('error', 'Invalid or expired verification link.');
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null; // Xóa token sau khi xác thực
        $user->save();

        return redirect()->route('login')->with('success', 'Email verified successfully.');
    }

}

