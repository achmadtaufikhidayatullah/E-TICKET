<nav class="navbar navbar-light bg-light shadow p-3 mb-5 bg-body rounded sticky-top">
    <div class="container-fluid container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('FrontAssets/img/logo.png') }}" alt="" height="50" class="d-inline-block align-text-top">
        </a>

        <div class="d-flex">
            @if(url()->current() == route('login'))
            <a href="{{ route('regist') }}" class="btn btn-md btn-warning-gradient rounded-pill shadow">Register</a>
            @elseif (url()->current() == route('regist') || url()->current() == route('regist.store') || url()->current() == route('regist.verification.success'))
            <a href="{{ route('login') }}" class="btn btn-md btn-warning-gradient rounded-pill shadow">Login</a>
            @else
            <div class="btn-group">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="" width="50"
                    class="rounded-circle dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <ul class="dropdown-menu shadow">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item" href="{{ route('logout') }}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</nav>
