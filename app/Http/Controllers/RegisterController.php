<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function index()
    {
        // Hiển thị form đăng ký
        return view('auth.register');
    }

    /**
     * Handle the registration of the user.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')  // Quay lại trang đăng ký
                             ->withErrors($validator) // Hiển thị lỗi xác thực
                             ->withInput(); // Giữ lại thông tin đã nhập
        }

        // Tạo mới người dùng
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Mã hóa mật khẩu
        $user->save();

        // Đăng ký thành công, chuyển hướng đến trang đăng nhập
        return redirect()->route('login')->with('success', 'Registration successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
