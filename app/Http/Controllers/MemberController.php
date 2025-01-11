<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $members = Member::paginate($perPage);

        return view('admin.member', compact('members'));
    }

    public function new()
    {
        return view('admin.create_member');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:255|unique:members,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // $data = $request->only(['name', 'email', 'gender', 'country']);
        // $data['password'] = bcrypt($request->password);

        $data = $request->only(['id','name', 'email']);
        $data['password'] = bcrypt($request->password);

        Member::create($data);


        return redirect()->route('member.index')->with('success', 'Member created successfully.');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('admin.edit_member', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|string|max:8|unique:members,id,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $member = Member::findOrFail($id);

        if ($request->filled('password')) {
            $request['password'] = bcrypt($request->password);
        } else {
            unset($request['password']);
        }
    
        $member->update($request->except('password'));
    
        return redirect()->route('member.index')->with('success', 'Member updated successfully.');

    }
}
