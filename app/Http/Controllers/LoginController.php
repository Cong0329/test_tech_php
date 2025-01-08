<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string', // Kiểm tra id
            'password' => 'required|string', // Kiểm tra password
        ]);

        // Tìm người dùng qua ID
        $user = User::where('id', $validated['id'])->first();

        if ($user && Hash::check($validated['password'], $user->password)) {
            // Kiểm tra nếu người dùng đã xác thực email hay chưa
            if (is_null($user->email_verified_at)) {
                // Đăng xuất người dùng ngay lập tức nếu email chưa được xác thực
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Please verify your email before logging in.',
                ]);
            }

            // Nếu tất cả đều hợp lệ, đăng nhập người dùng
            Auth::login($user);
            return redirect()->route('home');
        }

        // Nếu thông tin không hợp lệ
        return back()->withErrors([
            'id' => 'The provided credentials are incorrect.',
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Login $login)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Login $login)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Login $login)
    {
        //
    }
}
