@extends('layout.dashboard.app')

@section('title', $blog ? 'Edit Post' : 'Add Post')

@push('custom-styles')
    <link rel="stylesheet" href="../node_modules/summernote/dist/summernote-bs4.css">
    <link rel="stylesheet" href="../node_modules/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="../node_modules/codemirror/theme/duotone-dark.css">
    <link rel="stylesheet" href="../node_modules/selectric/public/selectric.css">
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
                                    <input type="hidden" id="slug" name="slug" value="{{ $blog['slug'] ?? '' }}">
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" id="title" name="title" class="form-control">
                                            <div class="invalid-feedback validationTitle"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="form-control">
                                            <div class="invalid-feedback validationThumbnail"></div>

                                            <div class="section-preview mt-3">
                                                <img src="" alt="preview" class="img-preview img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea class="summernote" id="content" name="content"></textarea>
                                            <div class="invalid-feedback validationContent"></div>
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
    <script>
        $('#thumbnail').change(function(e) {
            $('.img-preview').css('display', 'block')

            e.preventDefault();
            let reader = new FileReader();
            reader.onload = (e) => {
                $('.img-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        })
    </script>
@endpush
