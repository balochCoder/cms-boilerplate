@extends('layouts.backend.master')
@section('title')
    {{ __("All FAQ's") }}
@endsection
@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{ __("All FAQ's") }}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('FAQS') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ __("All FAQ's") }}</li>
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
                    <div class="col-sm-12 message"></div>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered data-table wrap">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Page</th>
                                            <th>Question</th>
                                            <th>Answer</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('faqs.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'page',
                        name: 'page'
                    },
                    {
                        data: 'question',
                        name: 'question'
                    },
                    {
                        data: 'answer',
                        name: 'answer'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                "order": [
                    [0, "asc"]
                ],
            });
        });
        $(document).on("click", ".remove", function(event) {
            var flag = confirm('Are You Sure want to Remove FAQ?');
            if (flag) {
                var url = '{{ route('faqs.destroy', ':id') }}'
                var id = $(this).data('id');
                url = url.replace(':id', id);
                console.log(id)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        let result = JSON.parse(data);
                        $('.message').html('<div class="alert alert-' + result.type +
                            ' alert-dismissible fade show" role="alert"><i class="mdi ' + result
                            .icon +
                            ' me-2"></i>' + result.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div>'
                        );
                        // $('.datatable').DataTable().ajax.reload();
                        let table = $('.data-table').DataTable();
                        table.row('#' + id).remove().draw(false);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            } else {
                event.preventDefault();
            }
        });
    </script>
@endsection
