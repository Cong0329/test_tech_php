<?php

namespace App\Http\Controllers;
use App\Models\Member;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('admin.member', ['members' => $members, 'content' => 'member']);
    }

    public function new()
    {
        return view('admin.create_member');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members',
            'phone' => 'required|digits:10',
        ]);

        Member::create($request->all());

        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('admin.edit_member', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $id,
            'phone' => 'required|digits:10',
        ]);

        $member = Member::findOrFail($id);
        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }

}
