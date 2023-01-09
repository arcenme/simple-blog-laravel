@extends('layout.dashboard.app')

@section('title', 'Post Blog')

@push('custom-styles')
    <link href="{{ asset('assets/vendor/datatables/css/datatables.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-row-reverse py-0">
            <button class="btn btn-success" id="add-post"><i class="fa fa-plus-square"></i> Add New Post</button>
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

@push('custom-scripts')
    <script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/js/dataTables.min.js') }}"></script>
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
            $('#table_blog').DataTable({
                searchDelay: 1000,
                processing: true,
                serverSide: true,
                pageLength: 25,
                order: [
                    [1, 'desc']
                ],
                ajax: {
                    type: "GET",
                    url: "{{ route('dashboard.blog') }}"
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
                        console.log
                        return `<a href="" class="btn btn-info btn-sm mx-1" data-slug="${raw.slug}" data-toggle="tooltip" data-placement="top" title="Comment"><i class="fas fa-comments"></i></a>
                        <a href="{{ route('dashboard.blog.post') }}?slug=${raw.slug}" class="btn btn-warning btn-sm mx-1" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="" class="btn btn-danger btn-sm mx-1" data-slug="${raw.slug}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></a>`
                    }
                }],
            });
        })
    </script>
@endpush
