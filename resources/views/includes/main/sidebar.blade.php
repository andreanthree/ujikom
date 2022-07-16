<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">{{ config('app.name_short') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">SP</a>
        </div>
        <ul class="sidebar-menu">
            @if (Auth::user()->role == 'USER')
                <li class="menu-header">Dashboard</li>
                <li><a class="nav-link" href="{{ route('user.dashboard') }}"><i class="fas fa-fire"></i>
                        <span>Dashboard</span></a></li>
            @endif

            @if (Auth::user()->role == 'ADMIN')
                <li class="menu-header">Dashboard</li>
                <li class="{{ request()->is('admin') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i>
                        <span>Dashboard</span></a>
                </li>
                <li class="menu-header">Data</li>
                <li class="{{ request()->is('admin/penulis*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('admin/penulis') }}">
                        <i class="fas fa-book"></i> <span>Penulis</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/artikel*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('admin/artikel') }}">
                        <i class="fas fa-book"></i> <span>Artikel</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/komentar*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('admin/komentar') }}">
                        <i class="fas fa-book"></i> <span>komentar</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->role == 'PENULIS')
                <li class="menu-header">Dashboard</li>
                <li class="{{ request()->is('penulis') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('penulis/') }}"><i class="fas fa-fire"></i>
                        <span>Dashboard</span></a>
                </li>

                <li class="menu-header">Data</li>
                <li class="{{ request()->is('penulis/artikelpenulis*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('penulis/artikelpenulis') }}">
                        <i class="fas fa-book"></i> <span>Artikel Saya</span>
                    </a>
                </li>
                {{-- <li class="{{ request()->is('penulis/komentar*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('penulis/komentar') }}">
            <i class="fas fa-book"></i> <span>komentar</span>
          </a>
        </li> --}}
            @endif

        </ul>

    </aside>
</div>
