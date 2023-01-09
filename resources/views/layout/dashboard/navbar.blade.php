<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            @if (auth('admin')->check())
                @include('layout.dashboard.navbar_admin')
            @elseif (auth('user')->check())
                @include('layout.dashboard.navbar_user')
            @else
                <a href="{{ route('login') }}" class="btn btn-warning btn-sm"><i class="fas fa-sign-in-alt"></i> Login</a>
            @endif
        </li>
    </ul>
</nav>
