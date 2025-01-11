@extends('layouts.app')

@section('content')
<style>
</style>
<div class="fix d-flex" style="height:100vh;">
    <div class="container justify-content-center align-items-center " style="width: 450px; margin: auto;">
        <div class="row ">
            <div class="col-md">
                <div class="card">
                    <div class="card-header text-center">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" required value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required value="{{ old('email') }}">
                            </div>
                            <div class="form-row">
                                <div class="col-md form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="male" {{ old('gender', $user->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $user->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $user->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-md form-group">
                                    <label for="country">Country</label>
                                    <select class="form-control" id="country" name="country" value="{{ old('country', $user->country ?? '') }}">
                                        <option value="" disabled selected>Choose</option>
                                        <option value="us" {{ old('country', $customer->country ?? '') == 'us' ? 'selected' : '' }}>United States</option>
                                        <option value="uk" {{ old('country', $customer->country ?? '') == 'uk' ? 'selected' : '' }}>United Kingdom</option>
                                        <option value="jp" {{ old('country', $customer->country ?? '') == 'jp' ? 'selected' : '' }}>Japan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group checkbox-group">
                                <label for="job" class="d-flex">Job</label>
                                <div class="d-flex justify-content-between">
                                    <label><input type="checkbox" name="job[]" value="student" {{ is_array(old('job')) && in_array('student', old('job')) ? 'checked' : '' }}> Student</label>
                                    <label><input type="checkbox" name="job[]" value="developer" {{ is_array(old('job')) && in_array('developer', old('job')) ? 'checked' : '' }}> Developer</label>
                                    <label><input type="checkbox" name="job[]" value="designer" {{ is_array(old('job')) && in_array('designer', old('job')) ? 'checked' : '' }}> Designer</label>
                                    <label><input type="checkbox" name="job[]" value="other" {{ is_array(old('other')) && in_array('other', old('job')) ? 'checked' : '' }}> Other</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                            </div>
                            <div class="row">
                                <div class="col-md text-center">
                                    <button type="submit" class="btn btn-success">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
