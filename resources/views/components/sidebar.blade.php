<div class="main-sidebar sidebar-style-2 shadow-lg">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand my-3">
            <a href="#!">
                <img src="{{ asset('FrontAssets/img/logo.png') }}" alt="" width="120">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#!">
                <img src="{{ asset('FrontAssets/img/logo-b.png') }}" alt="" width="20">
            </a>
        </div>
        <ul class="sidebar-menu">
            @if(auth()->user()->role == "Super Admin" || auth()->user()->role == "Admin")
            <li class="{{ Request::is('*dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-home"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="{{ Request::is('*users*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-user"></i> <span>User</span></a>
            </li>

            <li class="{{ Request::is('*event-list*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('event.index.admin') }}"><i class="fas fa-star"></i> <span>Event List</span></a>
            </li>

            <!-- <li class="{{ Request::is('*event-batch*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('batch.index') }}"><i class="fas fa-star"></i> <span>Event Batch</span></a>
            </li> -->
            @else
            <li class="{{ Request::is('*events*') || Request::is('*event-form*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('events.index') }}"><i class="fas fa-star"></i>
                    <span>Events</span></a>
            </li>
            <li class="{{ Request::is('*ticket*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('ticket.index') }}"><i class="fas fa-ticket"></i> <span>My Ticket</span></a>
            </li>
            @endif
        </ul>
    </aside>
</div>
