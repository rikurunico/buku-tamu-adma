<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="/">Stisla</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="/">St</a>
    </div>
    {{-- <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="/home">Home</a></li>
            </ul>
        </li>
        <li class="menu-header">Menu</li>
        <li class="nav-item dropdown {{ request()->routeIs('peserta') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                <i class="fas fa-user"></i>
                <span>Peserta</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('peserta') }}">Manage Peserta</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown {{ request()->routeIs('attendance') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                <i class="fas fa-clipboard-list"></i>
                <span>Daftar Hadir</span>
            </a>

            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('attendance') }}">List Daftar Hadir</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                <i class="fas fa-gift"></i>
                <span>Undian</span>
            </a>

            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('undian') }}">Undi Sekarang!</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown {{ request()->routeIs('winner') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                <i class="fas fa-trophy"></i>
                <span>Pemenang</span>
            </a>

            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('winner') }}">List Pemenang</a></li>
            </ul>
        </li>
    </ul> --}}

    @guest
        <ul class="sidebar-menu">
            <li class="menu-header">Buku Tamu</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i><span>Buku Tamu</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="/">Buku Tamu</a></li>
                </ul>
            </li>
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    @else
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('logout') }}" class="btn btn-danger btn-lg btn-block btn-icon-split"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    @endguest



</aside>
