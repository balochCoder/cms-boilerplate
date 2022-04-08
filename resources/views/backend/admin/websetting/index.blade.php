@extends('layouts.backend.master')
@section('title')
    {{ __('Web Settings') }}
@endsection
@section('styles')
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{ __('MANAGE WEB SETTINGS') }}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Settings') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ __('Web Setting') }}</li>
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
                                    <i class="mdi mdi-block-helper me-2"></i>
                                @else
                                    <i class="mdi mdi-check-all me-2"></i>
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
                    <div class="col-sm-9">
                        <div class="card">
                            <div class="card-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#contact" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">CONTACT INFORMATION</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#social" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">SOCIAL LINKS</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#logo" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">LOGO & FAVICON</span>
                                        </a>
                                    </li>

                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content p-3 text-muted">
                                    <div class="tab-pane active" id="contact" role="tabpanel">
                                        <div class="col-sm-9">
                                            <form class="needs-validation" method="POST" action="{{route('websettings.updateContact')}}"
                                                enctype="multipart/form-data" novalidate>
                                                @csrf
                                                <div class="row">
                                                    <h3 class="card-title">Contact Information</h3>
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label for="phone" class="form-label">Phone</label>
                                                            <input type="text" class="form-control" name="phone"
                                                                id="phone" placeholder="Phone No#"
                                                                value="{{ $contact->phone ?? '' }}">
                                                            <div class="invalid-feedback">
                                                                Please enter valid phone.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email"
                                                                id="email" placeholder="Email address"
                                                                value="{{ $contact->email ?? '' }}">
                                                            <div class="invalid-feedback">
                                                                Please enter valid email address.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Address</label>
                                                            <textarea rows="4" class="form-control" name="address" id="address"
                                                                placeholder="Address here">{{ $contact->address ?? '' }}</textarea>
                                                            <div class="invalid-feedback">
                                                                Please enter valid Address.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @canany(['websettings-add', 'websettings-edit'])
                                                <div>
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                </div>
                                                @endcanany
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="social" role="tabpanel">
                                        <div class="col-sm-9">
                                            <form class="needs-validation" method="POST" action="{{route('websettings.updateSocial')}}"
                                                enctype="multipart/form-data" novalidate>
                                                @csrf
                                                <div class="row">
                                                    <h3 class="card-title">Social Links</h3>
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label for="facebook" class="form-label">Facebook</label>
                                                            <input type="url" class="form-control" name="facebook"
                                                                id="facebook" placeholder="Facebook Link#"
                                                                value="{{ $links->facebook ?? '' }}">
                                                            <div class="invalid-feedback">
                                                                Please enter valid facebook.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label for="facebook" class="form-label">Instagram</label>
                                                            <input type="url" class="form-control" name="instagram"
                                                                id="instagram" placeholder="Instagram Link#"
                                                                value="{{ $links->instagram ?? '' }}">
                                                            <div class="invalid-feedback">
                                                                Please enter valid Instagram.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label for="twitter" class="form-label">Twitter</label>
                                                            <input type="url" class="form-control" name="twitter"
                                                                id="twitter" placeholder="Twitter Link#"
                                                                value="{{ $links->twitter ?? '' }}">
                                                            <div class="invalid-feedback">
                                                                Please enter valid Twitter.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label for="linkedin" class="form-label">LinkedIn</label>
                                                            <input type="url" class="form-control" name="linkedin"
                                                                id="linkedin" placeholder="LinkedIn Link#"
                                                                value="{{ $links->linkedin ?? '' }}">
                                                            <div class="invalid-feedback">
                                                                Please enter valid linkedin link.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label for="google" class="form-label">Google</label>
                                                            <input type="url" class="form-control" name="google"
                                                                id="google" placeholder="Account Link#"
                                                                value="{{ $links->google ?? '' }}">
                                                            <div class="invalid-feedback">
                                                                Please enter valid google account.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @canany(['websettings-add', 'websettings-edit'])
                                                <div>
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                </div>
                                                @endcanany
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="logo" role="tabpanel">
                                        <div class="col-sm-12">
                                            <form class="needs-validation" method="POST" action=""
                                                enctype="multipart/form-data" novalidate>
                                                @csrf
                                                <div class="row">
                                                    <h3 class="card-title">Logo & Favicon</h3>

                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="logo" class="form-label">Logo</label>
                                                            <input type="file" class="form-control" name="logo"
                                                                id="logo">
                                                            <div class="invalid-feedback">
                                                                Please select valid logo.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        @if (isset($logo))
                                                            <img src="{{ asset('assets/images/' . $logo->logo) }}"
                                                                class="rounded avatar-lg" alt="">
                                                        @else
                                                            <img src="{{ asset('assets/images/logo.svg') }}"
                                                                class="rounded avatar-lg" alt="">
                                                        @endif
                                                    </div>
                                                </div>

                                                @canany(['websettings-add', 'websettings-edit'])
                                                <div>
                                                    <button class="btn btn-primary" name="updateLogo" value="true"
                                                        type="submit">UPDATE LOGO</button>
                                                </div>
                                                @endcanany

                                            </form>
                                            <hr />
                                            <form class="needs-validation" method="POST" action=""
                                                enctype="multipart/form-data" novalidate>
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="mb-3">
                                                            <label for="favicon" class="form-label">Favicon</label>
                                                            <input type="file" class="form-control" name="favicon"
                                                                id="favicon">
                                                            <div class="invalid-feedback">
                                                                Please select valid Favicon.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        @if (isset($favicon))
                                                            <img src="{{ asset('assets/images/' . $favicon->favicon) }}"
                                                                class="rounded avatar-lg" alt="">
                                                        @else
                                                            <img src="{{ asset('assets/images/favicon.ico') }}"
                                                                class="rounded avatar-lg" alt="">
                                                        @endif
                                                    </div>

                                                </div>

                                                @canany(['websettings-add', 'websettings-edit'])
                                                <div>
                                                    <button class="btn btn-primary" name="updateFavicon" value="true"
                                                        type="submit">UPDATE FAVICON</button>
                                                </div>
                                                @endcanany

                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    {{ auth()->user()->name }} </h4>
                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        @if (isset(auth()->user()->image))
                                            <img src="{{ asset('assets/images/users/' . auth()->user()->image) }}"
                                                class="form-control img-thumbnail" alt="">
                                        @else
                                            <img src="{{ asset('assets/images/users/avatar-2.jpg') }}"
                                                class="form-control img-thumbnail" alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/backend/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pages/form-validation.init.js') }}"></script>
@endsection
