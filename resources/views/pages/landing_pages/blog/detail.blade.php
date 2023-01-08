@extends('layout.landing_pages.app')

@section('title', $blog->title)

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('assets/img/example-image.jpg') }}" class="img-fluid" alt="thumbnail" style="max-height: 450px">
                    </div>

                    <div class="content mt-5">
                        <h2>{{ $blog->author->name }}</h2>
                        <h6>Last modified: {{ $blog->updated_at->isoFormat('DD MMMM YYYY HH:mm') }}</h6>
                        {!! $blog->content !!}
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Comments</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                                <li class="media">
                                    <img alt="image" class="mr-3 rounded-circle" width="70" src="../assets/img/avatar/avatar-1.png">
                                    <div class="media-body">
                                        <div class="media-title mb-1">Rizal Fakhri</div>
                                        <div class="text-time">Yesterday</div>
                                        <div class="media-description text-muted">Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
