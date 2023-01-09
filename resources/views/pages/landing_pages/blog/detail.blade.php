@extends('layout.landing_pages.app')

@section('title', $blog->title)

@push('custom-styles')
    <link href="{{ asset('assets/vendor/izitoast/dist/css/iziToast.min.css') }}" rel="stylesheet">
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
                            <form class="row g-3" id="form-comment" name="form-comment">
                                <div class="col-md-6 position-relative">
                                    <label for="fullname" class="form-label">Fullname</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" value="" placeholder="Ari Suseno" required>
                                    <div class="invalid-feedback validationFullname"> </div>
                                </div>
                                <div class="col-md-6 position-relative">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" value="" placeholder="hello@arcen.me" required>
                                    <div class="invalid-feedback validationEmail"> </div>
                                </div>

                                <div class="col-12 position-relative mt-2">
                                    <label for="comment" class="form-label ">Comment</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="4" cols="50" required style="min-height: 150px"></textarea>
                                    <div class="invalid-feedback validationComment"> </div>
                                </div>
                                <div class="col-12 my-3">
                                    <button class="btn btn-primary btn-submit-comment" type="button">Submit comment</button>
                                </div>
                            </form>

                            <div class="section mt-5">
                                <ul class="list-unstyled list-unstyled-border list-unstyled-noborder comments-section"> </ul>
                            </div>

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
    <script src="{{ asset('assets/vendor/izitoast/dist/js/iziToast.min.js') }}"></script>
    <script>
        let comments = []

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // set error
            function setErrors(error, inputClass, validation, message) {
                if (error) $(inputClass).addClass('is-invalid')
                else $(inputClass).removeClass('is-invalid')
                $(validation).text(error ? error[0] : '')
            }

            function resetForm(form) {
                $(form).trigger('reset')
                $(`${form} .form-control`).removeClass('is-invalid')
            }

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
                        $('.btn-loadmore').prop('disabled', true)
                    },
                    success: function(res) {
                        const commantLength = comments.length
                        // add comment
                        comments = comments.concat(res.data)
                        // render comment
                        renderComment()
                        // buttn loadmore
                        $('.btn-loadmore').css('display', comments.length > 0 && commantLength !== comments.length && comments.length % 5 === 0 ? 'flex' : 'none')
                        $('.btn-loadmore').text('Load more comments')
                        $('.btn-loadmore').prop('disabled', false)
                    },
                    error: function(err) {
                        $('.btn-loadmore').css('display', comments.length > 0 ? 'flex' : 'none')
                        $('.btn-loadmore').text('Load more comments')
                        $('.btn-loadmore').prop('disabled', false)

                        iziToast.error({
                            title: 'Error',
                            message: err.responseJSON.message ?? err.statusText,
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

            // submit comment
            $('.btn-submit-comment').click(function() {
                $.ajax({
                    context: this,
                    type: 'POST',
                    url: "{{ route('blog.comment', ['slug' => $blog->slug]) }}",
                    data: {
                        fullname: $('#fullname').val(),
                        email: $('#email').val(),
                        comment: $('#comment').val()
                    },
                    beforeSend: function() {
                        $(this).prop('disabled', true)
                        $(this).text('submitting....')
                    },
                    success: function(res) {
                        $(this).prop('disabled', false)
                        $(this).text('Submit comment')

                        resetForm('#form-comment')

                        iziToast.success({
                            title: 'Error',
                            message: res.message ?? 'Success',
                            position: 'bottomRight'
                        });

                        setTimeout(() => {
                            window.location.reload()
                        }, 500);
                    },
                    error: function(err) {
                        $(this).prop('disabled', false)
                        $(this).text('Submit comment')

                        if (err.responseJSON.errors) {
                            if (err.responseJSON.errors.slug) {
                                resetForm('#form-comment')

                                return iziToast.error({
                                    title: 'Error',
                                    message: err.responseJSON.slug[0],
                                    position: 'bottomRight'
                                });
                            }

                            setErrors(err.responseJSON.errors.fullname, '#fullname', '.validationFullname');
                            setErrors(err.responseJSON.errors.email, '#email', '.validationEmail');
                            setErrors(err.responseJSON.errors.comment, '#comment', '.validationComment');

                            return true;
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
