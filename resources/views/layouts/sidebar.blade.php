<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="/">Stisla</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="/">St</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Buku Tamu</li>
        @guest
            <li class="nav-item dropdown  {{ Request::is('/') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i><span>Buku
                        Tamu</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="/">Form isi Buku Tamu</a></li>
                </ul>
            </li>
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    @else
        <ul class="sidebar-menu">
            <li class="nav-item dropdown {{ Request::is('/') || Request::is('buku-tamu*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i><span>Buku Tamu</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="/">Form isi Buku Tamu</a></li>
                    <li><a class="nav-link" href="{{ route('buku-tamu.index') }}">Data Buku Tamu</a></li>
                </ul>
            </li>
        </ul>
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
