@extends('layout.landing_pages.app')

@section('title', 'Blog')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                @if ($blogs->count() > 0)
                    @foreach ($blogs as $blog)
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <article class="article article-style-b">
                                <div class="article-header">
                                    <div class="article-image" data-background="../assets/img/news/img15.jpg"> </div>
                                    <div class="article-badge">
                                        <div class="article-badge-item bg-danger"><i class="far fa-comments"></i> {{ $blog->comment }}</div>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <div class="article-title">
                                        <h2><a href="{{ route('blog.detail', ['slug' => $blog->slug]) }}">{{ $blog->title }}</a></h2>
                                    </div>
                                    <p>{{ strip_tags($blog->preview) }}....</p>
                                    <div class="article-cta">
                                        <a href="{{ route('blog.detail', ['slug' => $blog->slug]) }}">Read More <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                @else
                    <div class="card-header">
                        <h4>Empty Data</h4>
                    </div>
                    <div class="card-body">
                        <div class="empty-state" data-height="400">
                            <div class="empty-state-icon">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>We couldn't find any data</h2>
                            <p class="lead">
                                Sorry we can't find any data, to get rid of this message, make at least 1 entry.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            @if ($blogs->count() > 0)
                <div class="d-flex justify-content-center">
                    {{ $blogs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
