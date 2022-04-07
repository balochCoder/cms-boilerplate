@extends('auth._layout')
@section('title')
    Login | CMS
@endsection
@section('content')
@if (Session::has('message'))
<div class="col-sm-12">
    <div class="alert alert-success alert-dismissible fade show" role="alert">

        <i class="mdi mdi-check-all me-2"></i>

        {{ __(Session::get('message')) }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
            aria-label="Close"></button>
    </div>
</div>
@endif
    <div class="card overflow-hidden">
        <div class="bg-primary bg-soft">
            <div class="row">
                <div class="col-7">
                    <div class="text-primary p-4">
                        <h5 class="text-primary">Welcome Back !</h5>
                        <p>Sign in to continue to Skote.</p>
                    </div>
                </div>
                <div class="col-5 align-self-end">
                    <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="auth-logo">
                <a href="#" class="auth-logo-light">
                    <div class="avatar-md profile-user-wid mb-4">
                        <span class="avatar-title rounded-circle bg-light">
                            <img src="assets/images/logo-light.svg" alt="" class="rounded-circle" height="34">
                        </span>
                    </div>
                </a>

                <a href="#" class="auth-logo-dark">
                    <div class="avatar-md profile-user-wid mb-4">
                        <span class="avatar-title rounded-circle bg-light">
                            <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                        </span>
                    </div>
                </a>
            </div>
            <div class="p-2">

                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email"
                            class="form-control @error('email') is-invalid @enderror {{ Session::has('error') ? 'is-invalid' : '' }}"
                            id="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required
                            autocomplete="email" autofocus>

                        @if (Session::has('error'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('error') }}</strong>
                            </span>
                        @endif
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter password" aria-label="Password" aria-describedby="password-addon"
                                name="password" required autocomplete="current-password">
                            <button class="btn btn-light " type="button" id="password-addon"><i
                                    class="mdi mdi-eye-outline"></i></button>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Remember Me
                        </label>
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">Log
                            In</button>
                    </div>
                    @if (Route::has('password.request'))
                        <div class="mt-4 text-center">
                            <a href="{{ route('password.request') }}" class="text-muted"><i
                                    class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                        </div>
                    @endif

                </form>
            </div>

        </div>
    </div>
    <div class="mt-5 text-center">

        <div>
            <p>Don't have an account ? <a href="{{ route('register') }}" class="fw-medium text-primary">Signup now </a>
            </p>
        </div>
    </div>
@endsection
