@extends('layouts.app')

@section('content')
<style>

</style>
<div class="fix d-flex" style="height:100vh;">
    <div class="container justify-content-center align-items-center " style="width: 450px; margin: auto;">
        <div class="row ">
            <div class="col-md">
                <div class="card">
                    <div class="card-header text-center">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="id" class=" col-form-label">{{ __('ID') }}</label>
                                <input id="id" type="text" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ old('id') }}" required autofocus>

                                @error('id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>

                            <div class="form-group">
                                <label for="password" class=" col-form-label">{{ __('Password') }}</label>    
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                            </div>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md text-center">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md text-center">
                                    <span class="mx-2">No account?</span>
                                    <a href="register">Register</a>
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
