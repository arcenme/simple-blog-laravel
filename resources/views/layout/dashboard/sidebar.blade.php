<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('index') }}">{{ env('APP_NAME') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('index') }}">AS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ request()->segment(2) === 'blog' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.blog') }}"> <i class="far fa-newspaper"></i> <span>Blog Entry</span> </a>
            </li>
        </ul>
        <ul class="sidebar-menu">
            <li class="{{ request()->segment(2) === 'profile' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard.profile') }}"> <i class="far fa-newspaper"></i> <span>Profile</span> </a>
            </li>
        </ul>
        <ul class="sidebar-menu">
            <li>
                <a class="nav-link" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> <span>Logout</span> </a>
            </li>
        </ul>
    </aside>
</div>
