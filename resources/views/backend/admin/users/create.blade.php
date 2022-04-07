@extends('layouts.backend.master')
@section('title')
    {{ __('Add User') }}
@endsection

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{ __('Add User') }}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Users') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ __('Add User') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    @if (Session::has('message'))
                        <div class="col-sm-12">
                            <div class="alert alert-{{ Session::get('type') }} alert-dismissible fade show" role="alert">
                                @if (Session::get('type') == 'danger')
                                    <i class="{{ Session::get('icon') }} me-2"></i>
                                @else
                                    <i class="{{ Session::get('icon') }} me-2"></i>
                                @endif
                                {{ __(Session::get('message')) }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="col-sm-12">
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-block-helper me-2"></i>
                                    {{ __($error) }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="col-sm-12 message"></div>
                    <div class="col-sm-12">
                        <form action="{{route('users.store')}}" class="needs-validation" method="POST" novalidate>
                            @csrf
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mb-3">

                                                    <label for="page" class="form-label">Roles</label>
                                                    <select class="form-select" data-placeholder="Choose Roles" id="role"
                                                        name="role" required focus>
                                                        <option value="">Select Role....</option>
                                                        @forelse ($roles as $role)
                                                            <option value="{{ $role }}">{{ Str::ucfirst($role) }}
                                                            </option>
                                                        @empty
                                                            <option disabled value="">No Role Found!</option>
                                                        @endforelse
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select role.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Full Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        id="name" placeholder="Last Name"
                                                        value="{{ old('name') }}" required>
                                                    <div class="invalid-feedback">
                                                        Please enter valid last name.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email"
                                                        placeholder="Email Address" value="{{ old('email') }}" required>
                                                    <div class="invalid-feedback">
                                                        Please enter valid email address.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" class="form-control" name="password"
                                                        id="password" placeholder="Password" required />
                                                    <div class="invalid-feedback">
                                                        Please enter valid password.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="confirm_password" class="form-label">Confirm
                                                        Password</label>
                                                    <input type="password" class="form-control" name="confirm_password"
                                                        id="confirm_password" placeholder="Confirm Password" required />
                                                    <div class="invalid-feedback">
                                                        Please enter valid confirm password.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div> <!-- end col -->
                            <div class="col-sm-12 mb-5">
                                <button type="submit" class="btn btn-primary">ADD USER</button>
                            </div>

                        </form>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
    </div>
@endsection
