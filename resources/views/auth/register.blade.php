@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>

                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>

                    <label for="password">Password</label>
                    <input type="password" name="password" required>

                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" required>

                    <button type="submit">Register</button>
                </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
