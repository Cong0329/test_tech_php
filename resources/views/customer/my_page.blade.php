@extends('customer.home')

@section('my_page')
<div class="container mt-5">
    <h1 class="fw-bold text-center">My Page</h1>
    <div class="card mt-4">
        <div class="card-header bg-success text-white">
            <h3 class="text-center">Customer Details</h3>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center mb-4">
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
            </div>
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ ucfirst($user->gender ?? 'N/A') }}</td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{ $user->country ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Job</th>
                    <td>{{ is_array($user->job) ? implode(', ', $user->job) : 'N/A' }}</td>
                </tr>
            </table>
            <div class="text-center mt-3">
                <a href="{{ route('customer.edit_page', $user->id) }}" class="btn btn-success">Edit My Information</a>
            </div>
        </div>
    </div>
</div>
@endsection
