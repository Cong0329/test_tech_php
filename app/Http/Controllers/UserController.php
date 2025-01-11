<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $users = User::paginate($perPage);

        return view('admin.customer', compact('users'));
    }

    public function new()
    {
        return view('admin.create_customer');
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

        $isAdmin = Auth::guard('admin')->check();

        $data = $request->only(['name', 'email', 'gender', 'country']);
        $data['password'] = bcrypt($request->password);

        if ($isAdmin) {
            $data['verified'] = true;
            $data['email_verified_at'] = now();
        }

        if ($request->has('job')) {
            $data['job'] = $request->job;
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_customer', compact('user'));
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

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully.');
    }
}
