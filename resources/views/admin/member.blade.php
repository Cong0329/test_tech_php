@extends('admin.home')

@section('member')
    <div class="title d-flex align-items-center justify-content-between">
        <h1 class="my-4 mx-auto fw-bold">Member List</h1>
        <a href="{{ route('members.new') }}" class="btn btn-success btn mx-5">Add</a>
    </div>

    
    <table class="table table-info">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>
                        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-outline-success py-1 mx-1">Edit</a>
                        <!-- <a href="{{ route('members.destroy', $member->id) }}" class="btn btn-outline-danger btn-sm">Delete</a> -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection