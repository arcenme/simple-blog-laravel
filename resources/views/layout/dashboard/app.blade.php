<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.dashboard.head')
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            @include('layout.dashboard.navbar')
            @include('layout.dashboard.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>@yield('title')</h1>
                    </div>

                    <div class="section-body">
                        @yield('content')
                    </div>
                </section>
            </div>
            @include('layout.dashboard.footer')
        </div>
    </div>

    @yield('modals')

    @include('layout.dashboard.scripts')
</body>

</html>
