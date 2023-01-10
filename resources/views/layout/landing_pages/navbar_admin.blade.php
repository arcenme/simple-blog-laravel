<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
    <div class="d-sm-none d-lg-inline-block">Hi, {{ auth('admin')->user()->name }}</div>
</a>
<div class="dropdown-menu dropdown-menu-right">
    <a href="{{ route('dashboard.blog') }}" class="dropdown-item has-icon">
        <i class="far fa-newspaper"></i> Blog
    </a>
    <a href="" class="dropdown-item has-icon">
        <i class="fas fa-comments"></i> Comments
    </a>
    <div class="dropdown-divider"></div>
    <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>
