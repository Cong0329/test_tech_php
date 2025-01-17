<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MemberController extends Controller
{
    public function index()
    {
        // $perPage = 10;
        // $members = Member::paginate($perPage);

        // return view('admin.member', compact('members'));

        $members = Member::paginate(10);
        $admins = Admin::paginate(10); 
        
        $allUsers = $members->concat($admins); 

        return view('admin.member', compact('allUsers', 'members'));
    }

    public function new()
    {
        return view('admin.create_member');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:8',
            'name' => 'string|max:255',
            'email' => 'email|unique:members',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!str_starts_with($validated['id'], 'MB')) {
            $validated['id'] = 'MB' . $validated['id'];
        }

        if (Member::where('id', $validated['id'])->exists()) {
            return back()->withErrors(['id' => 'The ID is already taken. Please choose another one.'])->withInput();
        }

        $data = [
            'id' => $validated['id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ];

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

    public function exportCSV()
    {
        $members = Member::all();
        $admins = Admin::all();

        $csvHeader = ["ID", "Name", "Email"];
        
        $csvData = $members->map(function ($user) {
            return [$user->id, $user->name, $user->email, 'Member'];
        });

        $csvData = $csvData->concat($admins->map(function ($user) {
            return [$user->id, $user->name, $user->email, 'Admin'];
        }));

        $response = new StreamedResponse(function () use ($csvHeader, $csvData) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $csvHeader);
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="members.csv"');

        return $response;
    }

}