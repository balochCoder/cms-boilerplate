@extends('layouts.backend.master')
@section('title')
    {{ __('Add Role') }}
@endsection

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{ __('Add Role') }}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Bookings') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ __('Add Role') }}</li>
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
                        <form action="{{ route('roles.store') }}" class="needs-validation" method="POST" novalidate>
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Role Name</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="Role Name" value="" required>
                                                <div class="invalid-feedback">
                                                    Please enter valid name.
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <h4>Permissions</h4>
                                        @php
                                            $previous_permission = '';
                                            $module = [];
                                        @endphp
                                        @foreach ($permissions as $permission)
                                            @php
                                                $permission_name = explode('-', $permission->name);
                                                $module_name = $permission_name[0];
                                                if ($module_name == $previous_permission) {
                                                    $module[$module_name][] = $permission_name[1];
                                                } else {
                                                    $previous_permission = $permission_name[0];
                                                    $module[$module_name][] = $permission_name[1];
                                                }
                                            @endphp
                                        @endforeach
                                        @php
                                            $module_wise_permission[] = $module;
                                            $upt_module = array_keys($module);
                                            $i = 0;
                                        @endphp
                                        <table class="table table-bordered wrap">
                                            <thead>
                                                <tr>
                                                    <th>Module</th>
                                                    <th>Add</th>
                                                    <th>Edit</th>
                                                    <th>View</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($module as $key => $mod)
                                                    <tr>
                                                        <td>{{ Str::ucfirst($key) }} </td>
                                                        @foreach ($mod as $per)
                                                            <td>
                                                                <input type="checkbox" name="permission[]"
                                                                    value="{{ $permissions[$i]->name }}">
                                                                {{ Str::ucfirst($per) }}
                                                            </td>
                                                            @php
                                                                $i++;
                                                            @endphp
                                                        @endforeach
                                                @endforeach
                                            </tbody>

                                        </table>

                                        <div class="col-sm-12 mb-5">
                                            <button type="submit" class="btn btn-primary">ADD ROLE</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

    <!-- form advanced init -->
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
@endsection

@section('css')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
