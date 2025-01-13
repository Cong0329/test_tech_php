@extends('admin.home')

@section('member')
    <h1 class="my-4 mx-auto fw-bold">Add Member</h1>
    <div class="container">
        <form action="{{ route('member.store') }}" method="POST" enctype="multipart/form-data" class="w-50 mx-auto">
            @csrf
            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <div class="input-group">
                    <span class="input-group-text" id="id-prefix">MB</span>
                    <input type="text" class="form-control" id="id" name="id" placeholder="Enter remaining part of ID" required>
                </div>
            </div>
            @error('id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection
