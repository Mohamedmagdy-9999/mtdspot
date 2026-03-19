@extends('website.layout')

@section('content')

<main>

    {{-- Page Header --}}
    <div class="page-header">
        <div class="container">
            <h1 class="page-header__title">Login</h1>
            <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="page-header__breadcrumb-link">Home</a>
                <span class="page-header__breadcrumb-separator">/</span>
                <span>Login</span>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="auth-form" id="login-form">

            <h2 class="auth-form__title">Welcome Back</h2>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert--danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Session Messages --}}
            @if (session('error'))
                <div class="alert alert--danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('message'))
                <div class="alert alert--success">
                    {{ session('message') }}
                </div>
            @endif

            <form class="form" action="{{ route('postLogin') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="form__group">
                    <label class="form__label">Email Address *</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="your.email@example.com"
                        class="form__input @error('email') is-invalid @enderror"
                    >
                    @error('email')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form__group">
                    <label class="form__label">Password *</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        class="form__input @error('password') is-invalid @enderror"
                    >
                    @error('password')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn--primary btn--lg" style="width: 100%; margin-top: 1rem;">
                    Login
                </button>

                {{-- Register Link --}}
                <p style="margin-top: 1rem; text-align: center; font-size: 0.9rem;">
                    Don’t have an account?
                    <a href="{{ route('register') }}"
                       style="color: var(--primary-color); font-weight: 600; margin-left: 5px;">
                        Sign up
                    </a>
                </p>

            </form>
        </div>
    </div>

</main>

@endsection
