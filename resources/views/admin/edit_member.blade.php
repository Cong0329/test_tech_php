@extends('admin.home')

@section('member')
    <h1 class="my-4 mx-auto fw-bold">Edit Member</h1>
    <div class="container">
        <form action="{{ route('member.update', $user->id) }}" method="POST" class="w-50 mx-auto">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
