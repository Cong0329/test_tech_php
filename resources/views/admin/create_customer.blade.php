@extends('admin.home')

@section('customer')
    <h1 class="my-4 mx-auto fw-bold">Add Customer</h1>
    <div class="container">
        <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data" class="w-50 mx-auto">
            @csrf
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
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <select class="form-control" id="country" name="country" value="{{ old('country', $user->country ?? '') }}">
                    <option value="" disabled selected>Choose</option>
                    <option value="us" {{ old('country', $customer->country ?? '') == 'us' ? 'selected' : '' }}>United States</option>
                    <option value="uk" {{ old('country', $customer->country ?? '') == 'uk' ? 'selected' : '' }}>United Kingdom</option>
                    <option value="jp" {{ old('country', $customer->country ?? '') == 'jp' ? 'selected' : '' }}>Japan</option>
                </select>
            </div>
            <div class="mb-3">
            <label for="job" class="text-center">Job</label>
                <div class="d-flex justify-content-between">
                    <label><input type="checkbox" name="job[]" value="student" {{ is_array(old('job')) && in_array('student', old('job')) ? 'checked' : '' }}> Student</label>
                    <label><input type="checkbox" name="job[]" value="developer" {{ is_array(old('job')) && in_array('developer', old('job')) ? 'checked' : '' }}> Developer</label>
                    <label><input type="checkbox" name="job[]" value="designer" {{ is_array(old('job')) && in_array('designer', old('job')) ? 'checked' : '' }}> Designer</label>
                    <label><input type="checkbox" name="job[]" value="other" {{ is_array(old('other')) && in_array('other', old('job')) ? 'checked' : '' }}> Other</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection