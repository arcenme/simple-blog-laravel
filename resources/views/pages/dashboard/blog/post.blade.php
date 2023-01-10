@extends('layout.dashboard.app')

@section('title', $blog ? 'Edit Post' : 'Add Post')

@push('custom-styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="card">
        <div class="card-body pt-1">
            <div class="x_content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('dashboard.blog.post') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method($blog ? 'PUT' : 'POST')
                                    <input type="hidden" id="slug" name="slug" value="{{ $blog['slug'] ?? '' }}">
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? ($blog['title'] ?? '') }}">
                                            @error('title')
                                                <div class="invalid-feedback validationTitle">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title Slug</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" id="title_slug" name="title_slug" class="form-control @error('title_slug') is-invalid @enderror" value="{{ old('title_slug') ?? ($blog['slug'] ?? '') }}">
                                            @error('title_slug')
                                                <div class="invalid-feedback validationTitleSlug">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="form-control @error('thumbnail') is-invalid @enderror" value="{{ old('thumbnail') ?? '' }}">
                                            @error('thumbnail')
                                                <div class="invalid-feedback validationThumbnail">{{ $message }}</div>
                                            @enderror
                                            <div class="section-preview mt-3">
                                                <img src="{{ old('thumbnail') ?? ($blog && $blog['thumbnail'] ? env('APP_URL') . '/storage/' . $blog['thumbnail'] : '') }}" alt="" class="img-preview img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea class="summernote form-control @error('content') is-invalid @enderror" id="content" name="content">{{ old('content') ?? ($blog['content'] ?? '') }}</textarea>
                                            @error('content')
                                                <div class="invalid-feedback validationContent">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button class="btn btn-primary" type="submit">Publish</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        // preview thumbnail
        $('#thumbnail').change(function(e) {
            $('.img-preview').css('display', 'block')

            e.preventDefault();
            let reader = new FileReader();
            reader.onload = (e) => {
                $('.img-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        })

        // crewate slug
        $('#title').keyup(function() {
            const slug = $(this).val().toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-')

            $('#title_slug').val(slug)
        })

        //setup content
        $('#summernote').summernote({
            tabsize: 2,
            height: 100,
        });
    </script>
@endpush
