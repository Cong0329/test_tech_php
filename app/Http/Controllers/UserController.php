<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.member', ['users' => $users]);
    }

    public function create()
    {
        return view('admin.create_member');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'nullable|in:male,female,other',
            'country' => 'nullable|string|max:255',
            'job' => 'nullable|array',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        User::create($request->all());

        return redirect()->route('member.index')->with('success', 'Member created successfully.');
            // $data = $request->all();
            // $data['password'] = bcrypt($request->password);
    
            // if ($request->has('job')) {
            //     $data['job'] = json_encode($request->job);
            // }
    
            // if ($request->hasFile('avatar')) {
            //     $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            // }
    
            // User::create($data);
    
            // return redirect()->route('member.index')->with('success', 'Member created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_member', compact('user'));
    }

    public function update(Request $request, $id)
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
        $user->update($request->all());

        return redirect()->route('member.index')->with('success', 'Member updated successfully.');
        // $user = User::findOrFail($id);
        // $data = $request->all();
    
        // // Xử lý job thành JSON nếu có
        // if ($request->has('job')) {
        //     $data['job'] = json_encode($request->job);
        // }
    
        // // Lưu avatar nếu có
        // if ($request->hasFile('avatar')) {
        //     $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        // }
    
        // if (!empty($request->password)) {
        //     $data['password'] = bcrypt($request->password);
        // } else {
        //     unset($data['password']);
        // }
    
        // $user->update($data);
    
        // return redirect()->route('member.index')->with('success', 'Member updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('member.index')->with('success', 'Member deleted successfully.');
    }
}