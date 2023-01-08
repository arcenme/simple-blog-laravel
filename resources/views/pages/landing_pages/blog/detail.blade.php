@extends('layout.landing_pages.app')

@section('title', $blog->title)

@push('custom-styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

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
                            <ul class="list-unstyled list-unstyled-border list-unstyled-noborder comments-section"> </ul>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success btn-sm btn-loadmore" style="display: none">Load more comments</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>
        let comments = []

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // render comment
            function renderComment() {
                let html = comments.map(comment => {
                    return `<li class="media">
                                <div class="media-body">
                                    <div class="media-title mb-1"> ${comment.name}</div>
                                    <div class="text-time">${moment(comment.created_at).format('DD MMMM YYYY HH:mm')}</div>
                                    <div class="media-description text-muted">${comment.content}</div>
                                </div>
                            </li>`
                })
                // display comment
                $('.comments-section').empty().append(html)

                // buttn loadmore
                $('.btn-loadmore').css('display', comments.length > 0 && comments.length % 5 === 0 ? 'flex' : 'none')
                $('.btn-loadmore').text('Load more comments')
            }

            // get comment data
            function fetchComment() {
                $.ajax({
                    context: this,
                    type: 'GET',
                    url: "{{ route('blog.comment', ['slug' => $blog->slug]) }}",
                    data: {
                        offset: comments.length
                    },
                    beforeSend: function() {
                        $('.btn-loadmore').css('display', comments.length > 0 ? 'flex' : 'none')
                        $('.btn-loadmore').text('...loading')
                    },
                    success: function(res) {
                        comments = comments.concat(res.data)

                        renderComment()
                    },
                    error: function(err) {
                        $('.btn-loadmore').css('display', comments.length > 0 ? 'flex' : 'none')
                        $('.btn-loadmore').text('Load more comments')

                        iziToast.error({
                            title: 'Error',
                            message: err.responseJSON.message ? err.responseJSON.message : err.statusText,
                            position: 'bottomRight'
                        });
                    }
                })
            }

            fetchComment()

            // load more comment
            $('.btn-loadmore').click(function() {
                fetchComment()
            })

        })
    </script>
@endpush
