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

        // Attempt to authenticate the user by ID and Password
        $user = User::where('id', $validated['id'])->first(); // Tìm người dùng qua ID

        if ($user && Hash::check($validated['password'], $user->password)) {
            // Nếu tìm thấy người dùng và mật khẩu hợp lệ
            Auth::login($user); // Đăng nhập người dùng
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
