<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MyPageController extends Controller
{
    public function index()
    {
        return view('customer.my_page');
    }

    public function myPage()
    {
        $user = Auth::user();

        return view('customer.my_page', compact('user'));
    }

    public function editMyPage($id)
    {
        $user = User::findOrFail($id);
        return view('customer.edit_page', compact('user'));
    }

    public function updateMyPage(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'gender' => 'nullable|in:male,female,other',
            'country' => 'nullable|string|max:255',
            'job' => 'nullable|array',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);
        $data = $request->only(['name', 'email', 'gender', 'country']);

        if ($request->has('job')) {
            $data['job'] = $request->job;
        } else {
            $data['job'] = [];
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(storage_path('app/public/avatars/' . $user->avatar))) {
                unlink(storage_path('app/public/avatars/' . $user->avatar));
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('customer.my_page')->with('success', 'Updated successfully.');
    }
}
