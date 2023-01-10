@extends('layout.dashboard.app')

@section('title', 'Comment Management')

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
        </div>
        <div class="card-body pt-1">
            <div class="x_content">
                <table id="table_comment" class="table table-striped table-bordered table-sm" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th width='10px'>No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created Date</th>
                            <th>Comment</th>
                            <th width='50px'></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Start Delete Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="delete-modal" data-backdrop="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <input type="hidden" name="delete-id" id="delete-id">
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
            const tableComment = $('#table_comment').DataTable({
                searchDelay: 1000,
                processing: true,
                serverSide: true,
                pageLength: 25,
                order: [
                    [1, 'desc']
                ],
                ajax: {
                    type: "GET",
                    url: "{{ route('dashboard.comment') }}",
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
                    data: 'name',
                    name: 'comments.name',
                }, {
                    className: 'border-right',
                    data: 'email',
                    name: 'comments.email',
                }, {
                    className: 'border-right',
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data) {
                        return moment(data).format('DD MMMM YYYY HH:mm')
                    }
                }, {
                    className: 'border-right',
                    data: 'content',
                    name: 'comments.content',
                }, {
                    className: 'border-right text-center',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, raw) {
                        return `<button type="button" class="btn btn-danger btn-delete-blog btn-sm mx-1" data-id="${raw.id}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>`
                    }
                }],
            });

            // reload datatable
            $('#filter').change(function() {
                tableComment.ajax.reload()
            })

            // delete modal
            $('body').on('click', '.btn-delete-blog', function() {
                $('.tooltip').tooltip('hide');
                $('#delete-id').val($(this).data('id'))
                $('#delete-modal').modal('show')
            })

            // submit delete
            $('#submit-delete-modal').click(function() {
                $.ajax({
                    context: this,
                    url: "{{ route('dashboard.comment') }}",
                    type: "POST",
                    data: {
                        _method: 'DELETE',
                        id: $('#delete-id').val()
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

                        tableComment.ajax.reload()
                    },
                    error: function(err) {
                        $(this).prop('disabled', false)
                        $(this).text('Delete')

                        if (err.responseJSON.errors?.id) {
                            $('#delete-id').val('')
                            $('#delete-modal').modal('hide')
                            iziToast.error({
                                title: 'Error',
                                message: err.responseJSON.errors?.id[0],
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
