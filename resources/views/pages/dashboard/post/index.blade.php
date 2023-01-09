@extends('layout.dashboard.app')

@section('title', 'Post Blog')

@push('custom-styles')
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-row-reverse py-0">
            <button class="btn btn-success" id="add"><i class="fa fa-plus-square"></i> Add New Post</button>
        </div>
        <div class="card-body pt-1">
            <div class="x_content">
                <table id="table_theme" class="table table-striped table-bordered table-sm" style="width:100%">
                    <thead>
                        <tr class="text-center">
                            <th width='10px'>No.</th>
                            <th>Title</th>
                            <th width='120px'></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
