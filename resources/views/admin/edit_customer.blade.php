@extends('admin.home')

@section('customer')
    <h1 class="my-4 mx-auto fw-bold">Edit Customer</h1>
    <div class="container">
        <form action="{{ route('customer.update', $user->id) }}" method="POST" class="w-50 mx-auto" enctype="multipart/form-data">
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
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <select class="form-control" id="country" name="country">
                    <option value="" disabled {{ old('country', $user->country) == '' ? 'selected' : '' }}>Choose</option>
                    <option value="us" {{ old('country', $user->country) == 'us' ? 'selected' : '' }}>United States</option>
                    <option value="uk" {{ old('country', $user->country) == 'uk' ? 'selected' : '' }}>United Kingdom</option>
                    <option value="jp" {{ old('country', $user->country) == 'jp' ? 'selected' : '' }}>Japan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="job" class="form-label">Job</label>
                <div class="d-flex justify-content-between">
                    <label>
                        <input type="checkbox" name="job[]" value="student" 
                               {{ is_array($user->job) && in_array('student', $user->job) ? 'checked' : '' }}>
                        Student
                    </label>
                    <label>
                        <input type="checkbox" name="job[]" value="developer" 
                               {{ is_array($user->job) && in_array('developer', $user->job) ? 'checked' : '' }}>
                        Developer
                    </label>
                    <label>
                        <input type="checkbox" name="job[]" value="designer" 
                               {{ is_array($user->job) && in_array('designer', $user->job) ? 'checked' : '' }}>
                        Designer
                    </label>
                    <label>
                        <input type="checkbox" name="job[]" value="other" 
                               {{ is_array($user->job) && in_array('other', $user->job) ? 'checked' : '' }}>
                        Other
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                @if ($user->avatar)
                    <div>
                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Current Avatar" width="100">
                    </div>
                @endif
                <input type="file" class="form-control" id="avatar" name="avatar">
            </div>

            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
