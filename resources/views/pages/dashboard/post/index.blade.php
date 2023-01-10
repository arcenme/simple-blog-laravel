@extends('layout.dashboard.app')

@section('title', 'Blog Entry')

@push('custom-styles')
    <link href="{{ asset('assets/vendor/izitoast/dist/css/iziToast.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/css/datatables.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex">
            @if (auth('admin')->check())
                <div class="p-2">
                    <div class="row mx-2">
                        <label for="filter" class="col-form-label pl-0 pr-3">Filter</label>
                        <div>
                            <select class="form-control px-3" id="filter" name="filter" style="width: 100px">
                                <option value="all">All</option>
                                <option value="mine" selected>My Post</option>
                            </select>
                        </div>
                    </div>
                </div>
            @endif
            <div class="ml-auto p-2">
                <a href="{{ route('dashboard.blog.post') }}" class="btn btn-success"><i class="fa fa-plus-square"></i> Add New Posst</a>
            </div>
        </div>
        <div class="card-body pt-1">
            <div class="x_content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <table id="table_blog" class="table table-striped table-bordered table-sm" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th width='10px'>No.</th>
                            <th>Publish Date</th>
                            <th>Title</th>
                            <th width='120px'></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modals')

    @if (auth('admin')->check())
        <!-- Start Delete Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="delete-modal" data-backdrop="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <input type="hidden" name="delete-slug" id="delete-slug">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger"><b>data will be lost forever, are you sure? </b></p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary text-dark" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" name="submit-delete-modal" id="submit-delete-modal">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Delete Modal -->
    @endif
@endsection

@push('custom-scripts')
    <script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/izitoast/dist/js/iziToast.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("body").tooltip({
                selector: '[data-toggle=tooltip]'
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // datatable
            const tableBlog = $('#table_blog').DataTable({
                searchDelay: 1000,
                processing: true,
                serverSide: true,
                pageLength: 25,
                order: [
                    [1, 'desc']
                ],
                ajax: {
                    type: "GET",
                    url: "{{ route('dashboard.blog') }}",
                    data: function(d) {
                        d.filter = $('#filter').val()
                        return d;
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'border-right',
                    searchable: false,
                    orderable: false
                }, {
                    className: 'border-right',
                    data: 'publish_date',
                    name: 'created_at',
                    render: function(data) {
                        return moment(data).format('DD MMMM YYYY HH:mm')
                    }
                }, {
                    className: 'border-right',
                    data: 'title',
                    name: 'title',
                }, {
                    className: 'border-right text-center',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, raw) {
                        const isAdmin = "{{ auth('admin')->check() ? '1' : '0' }}";

                        return `<a href="" class="btn btn-info btn-sm mx-1" data-slug="${raw.slug}" data-toggle="tooltip" data-placement="top" title="Comment"><i class="fas fa-comments"></i></a>
                                <a href="{{ route('dashboard.blog.post') }}?slug=${raw.slug}" class="btn btn-warning btn-sm mx-1" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
                                ${isAdmin == '1' ? `<button type="button" class="btn btn-danger btn-delete-blog btn-sm mx-1" data-slug="${raw.slug}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>` : ''}`
                    }
                }],
            });

            // reload datatable
            $('#filter').change(function() {
                tableBlog.ajax.reload()
            })

            // delete modal
            $('body').on('click', '.btn-delete-blog', function() {
                $('.tooltip').tooltip('hide');
                $('#delete-slug').val($(this).data('slug'))
                $('#delete-modal').modal('show')
            })

            // submit delete
            $('#submit-delete-modal').click(function() {
                $.ajax({
                    context: this,
                    url: "{{ route('dashboard.blog.post') }}",
                    type: "POST",
                    data: {
                        _method: 'DELETE',
                        slug: $('#delete-slug').val()
                    },
                    beforeSend: function() {
                        $(this).prop('disabled', true)
                        $(this).text('...deleting')
                    },
                    success: function(res) {
                        $(this).prop('disabled', false)
                        $(this).text('Delete')

                        $('#delete-modal').modal('hide')

                        iziToast.success({
                            title: 'Suceess',
                            message: res.message ?? 'Success',
                            position: 'bottomRight'
                        });

                        tableBlog.ajax.reload()
                    },
                    error: function(err) {
                        $(this).prop('disabled', false)
                        $(this).text('Delete')

                        if (err.responseJSON.errors?.slug) {
                            $('#delete-slug').val('')
                            $('#delete-modal').modal('hide')
                            iziToast.error({
                                title: 'Error',
                                message: err.responseJSON.errors?.slug[0],
                                position: 'bottomRight'
                            });
                        }

                        iziToast.error({
                            title: 'Error',
                            message: err.responseJSON.message ?? err.statusText,
                            position: 'bottomRight'
                        });
                    }
                })
            })
        })
    </script>
@endpush
