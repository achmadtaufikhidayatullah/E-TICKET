<div class="navbar-bg bg-secondary"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            @desktop
            <li><a href="#"
                    data-toggle="sidebar"
                    class="nav-link nav-link-lg"><i class="fas fa-bars text-dark"></i></a></li>
            @enddesktop
            @mobile
            <li>
                <a href="#"
                    class="nav-link nav-link-lg">
                    <img src="{{ asset('FrontAssets/img/logo-b.png') }}" alt="" width="20">
                </a>
            </li>
            @endmobile
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#"
                data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user text-dark">
                <img alt="image"
                    src="{{ asset('img/avatar/avatar-4.png') }}"
                    class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block text-dark">Hi, {{ auth()->user()->name ?? 'Guest' }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a id="logout" href="#"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
