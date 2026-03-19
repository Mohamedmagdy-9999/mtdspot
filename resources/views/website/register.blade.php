@extends('website.layout')

@section('content')

<main>

    <div class="page-header">
        <div class="container">
            <h1 class="page-header__title">Signup</h1>
            <nav class="page-header__breadcrumb">
                <a href="{{ route('home') }}">Home</a> /
                <span>Signup</span>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="auth-form">

            <h2 class="auth-form__title">Create Account</h2>

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

            {{-- Session Message --}}
            @if (session('message'))
                <div class="alert alert--success">
                    {{ session('message') }}
                </div>
            @endif

            <form class="form" action="{{ route('create_account') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Name --}}
                <div class="form__group">
                    <label class="form__label">Full Name *</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="form__input @error('name') is-invalid @enderror"
                        placeholder="John Doe"
                    >
                    @error('name')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form__group">
                    <label class="form__label">Email Address *</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form__input @error('email') is-invalid @enderror"
                        placeholder="your.email@example.com"
                    >
                    @error('email')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="form__group">
                    <label class="form__label">Phone Number *</label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        class="form__input @error('phone') is-invalid @enderror"
                        placeholder="+20xxxxxxxxxx"
                    >
                    @error('phone')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form__group">
                    <label class="form__label">Password *</label>
                    <input
                        type="password"
                        name="password"
                        class="form__input @error('password') is-invalid @enderror"
                        placeholder="At least 8 characters"
                    >
                    @error('password')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form__group">
                    <label class="form__label">Confirm Password *</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form__input"
                        placeholder="Confirm password"
                    >
                </div>

                {{-- Image --}}
                <div class="form__group">
                    <label class="form__label">Profile Image</label>
                    <input type="file" name="image" class="form__input">
                </div>

                {{-- Terms --}}
                <div class="form__group">
                    <label>
                        <input type="checkbox" name="terms" {{ old('terms') ? 'checked' : '' }}>
                        I agree to the Terms & Conditions *
                    </label>
                    @error('terms')
                        <span class="form__error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn--primary btn--lg" style="width:100%">
                    Create Account
                </button>

                <p style="margin-top:1rem;text-align:center">
                    Already have an account?
                    <a href="{{ route('login') }}">Login</a>
                </p>

            </form>
        </div>
    </div>

</main>

@endsection
