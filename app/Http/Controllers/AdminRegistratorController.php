<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminRegistratorController extends Controller
{
    public function index()
    {
        return view('admin.registrator'); 
    }
    public function create()
    {
        return view('admin.registrator_admin');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:8', 
            'name' => 'string|max:255',
            'email' => 'email|unique:admins,email', 
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!str_starts_with($validated['id'], 'AD')) {
            $validated['id'] = 'AD' . $validated['id'];
        }

        if (Admin::where('id', $validated['id'])->exists()) {
            return back()->withErrors(['id' => 'The ID is already taken. Please choose another one.'])->withInput();
        }

        $data = [
            'id' => $validated['id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ];

        Admin::create($data);

        return redirect()->route('member.index')->with('success', 'Admin created successfully.');
    }


}