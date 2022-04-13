@extends('layouts.backend.master')
@section('title')
    {{ __('Edit Faq') }}
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{ __('Edit Faq') }}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __("Faq's") }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('Edit Faq') }}</li>
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
                    <form class="needs-validation" method="POST" action="{{ route('faqs.update',$faq->id) }}" novalidate>
                        <div class="row">
                            @csrf
                            @method('PUT')
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="mb-3">
                                                    <label for="page" class="form-label">Pages</label>
                                                    <select class="form-select" data-placeholder="Choose Pages" id="page"
                                                        name="page" required focus>
                                                        @forelse ($pages as $page)
                                                            <option value="{{ $page->slug }}"
                                                                {{ $page->slug == $faq->page ? 'selected' : '' }}>
                                                                {{ Str::ucfirst($page->name) }}
                                                            </option>
                                                        @empty
                                                            <option disabled value="">No Page Found!</option>
                                                        @endforelse
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select page.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="mb-3">
                                                    <label for="question" class="form-label">Question</label>
                                                    <input type="text" class="form-control" name="question" id="question"
                                                        placeholder="Question here" value="{{$faq->question }}" required>
                                                    <div class="invalid-feedback">
                                                        Please enter valid question.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label for="answer" class="form-label">Answer</label>
                                                    <textarea rows="4" class="form-control" name="answer" id="answer" placeholder="Answer here"
                                                        required>{{ $faq->answer }}</textarea>
                                                    <div class="invalid-feedback">
                                                        Please enter valid answer.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div> <!-- end col -->
                            <div class="col-sm-12 mb-5">
                                <button type="submit" class="btn btn-primary">UPDATE FAQ</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
    </div>
@endsection
