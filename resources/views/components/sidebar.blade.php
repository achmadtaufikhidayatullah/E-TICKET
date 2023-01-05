<div class="main-sidebar sidebar-style-2 shadow-lg">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand my-3">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('FrontAssets/img/logo.png') }}" alt="" width="120">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('FrontAssets/img/logo-b.png') }}" alt="" width="20">
            </a>
        </div>
        <ul class="sidebar-menu">
            <!-- <li class="menu-header">Menu</li> -->
            <li class="{{ Request::is('*home*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-home"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="{{ Request::is('*events*') || Request::is('*event-form*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('events.index') }}"><i class="fas fa-star"></i>
                    <span>Events</span></a>
            </li>
            <li class="{{ Request::is('*ticket*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('ticket.index') }}"><i class="fas fa-ticket"></i> <span>My Ticket</span></a>
            </li>

            <li class="{{ Request::is('*users*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-user"></i> <span>User</span></a>
            </li>

            <li class="{{ Request::is('*event-list*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('event.index.admin') }}"><i class="fas fa-star"></i> <span>Event List</span></a>
            </li>

            <li class="{{ Request::is('*event-batch*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('batch.index') }}"><i class="fas fa-star"></i> <span>Event Batch</span></a>
            </li>
        </ul>

        <!-- <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs" class="btn btn-warning btn-lg btn-block btn-icon-split">
                <i class="fas fa-globe"></i> Back to Main Page
            </a>
        </div> -->
    </aside>
</div>
