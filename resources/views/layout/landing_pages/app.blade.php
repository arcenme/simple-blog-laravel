<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.landing_pages.head')
</head>

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg" style="max-height: 70px"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="{{ route('index') }}" class="navbar-brand sidebar-gone-hide">{{ env('APP_NAME') }}</a>
                <div class="navbar-nav">
                    <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
                </div>
                @include('layout.landing_pages.sidebar')
                <div class="form-inline ml-auto"> </div>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        @if (auth('admin')->check())
                            @include('layout.landing_pages.navbar_admin')
                        @elseif (auth('user')->check())
                            @include('layout.landing_pages.navbar_user')
                        @else
                            <a href="{{ route('login') }}" class="btn btn-warning btn-sm"><i class="fas fa-sign-in-alt"></i> Login</a>
                        @endif
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <div class="main-content " style="padding-top: 120px">
                <section class="section">
                    <div class="section-header">
                        <h1>@yield('title')</h1>
                    </div>

                    <div class="section-body">
                        @yield('content')
                    </div>
                </section>
            </div>
            @include('layout.landing_pages.footer')
        </div>
    </div>

    @include('layout.landing_pages.scripts')
</body>

</html>
