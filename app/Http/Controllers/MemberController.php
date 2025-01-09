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

}
