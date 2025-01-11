@extends('admin.home')

@section('member')
<style>

</style>
<div class="title d-flex align-items-center justify-content-between">
    <h1 class="my-4 mx-auto fw-bold">Member List</h1>
    <a href="{{ route('member.new') }}" class="btn btn-success btn mx-5">Add</a>
</div>
<table class="table table-info">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($members as $member)
        <tr>
            <!-- <td>{{ $loop->iteration + (($members->currentPage() - 1) * $members->perPage()) }}</td> -->
            <td>{{ $member->id }}</td>
            <td>{{ $member->name }}</td>
            <td>{{ $member->email }}</td>
            <td>
                <a href="{{ route('member.edit', $member->id) }}" class="btn btn-outline-success py-1 mx-1">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center py-2">
    {!! $members->links() !!}
</div>

@endsection
