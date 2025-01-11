@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
        
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container py-1">
            <a class="navbar-brand" href="{{ url('/customer/home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    
                </ul>
                <ul class="navbar-nav ms-auto">
                    <form class="d-flex ms-auto" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width: 300px;">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </ul>

                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-2 p-2 pt-1 mt-3" style="height: 100vh; background-color:rgb(21 171 128)">
            <ul class="nav flex-column font-weight-bold">
                <li class="nav-item nav-dad my-1 py-1 {{ Request::is('customer/home') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('customer.home') }}">
                        <div class="project-nav-list__icon-wrap"></div>
                        <span class="project-nav-list__text pl-2">Home</span>
                    </a>
                </li>

                <li class="nav-item nav-dad my-1 py-1 {{ Request::is('customer/my_page') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('customer.my_page') }}">
                        <div class="project-nav-list__icon-wrap"></div>
                        <span class="project-nav-list__text pl-2">Customer</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-md mx-auto p-2 pt-1 mt-3 text-center bg-white">
            @if (Request::is('customer/my_page'))
                @yield('my_page')
            @else
                @yield('home')
            @endif
        </div>
    </div>

</div>
@endsection
