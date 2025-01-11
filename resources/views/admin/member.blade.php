@extends('admin.home')

@section('member')
<div class="title d-flex align-items-center justify-content-between">
    <h1 class="my-4 mx-auto fw-bold">Member List</h1>
    <a href="{{ route('member.new') }}" class="btn btn-success btn mx-5">Add</a>
</div>
<table class="table table-info">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->password }}</td>
            <td>
                <a href="{{ route('member.edit', $user->id) }}" class="btn btn-outline-success py-1 mx-1">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
