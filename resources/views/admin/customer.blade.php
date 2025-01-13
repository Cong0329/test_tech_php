@extends('admin.home')

@section('customer')
<style>

</style>
<div class="title d-flex align-items-center justify-content-between">
    <h1 class="my-4 mx-auto fw-bold">Customer List</h1>
    <a href="{{ route('customer.new') }}" class="btn btn-success btn mx-5">Add</a>
</div>
<table class="table table-info">
    <thead>
        <tr>
            <th>ID</th>
            <th>Avatar</th>
            <th>Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Country</th>
            <th>Job</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td><img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;"></td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->gender }}</td>
            <td>{{ $user->country }}</td>
            <td>{{ is_array($user->job) ? implode(', ', $user->job) : 'N/A' }}</td>
            <td>
                <a href="{{ route('customer.edit', $user->id) }}" class="btn btn-outline-success py-1 mx-1">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('customer.export') }}" class="btn btn-info btn mx-5 float-right">Export CSV</a>

<div class="d-flex justify-content-center py-2">
    {!! $users->links() !!}
</div>

@endsection