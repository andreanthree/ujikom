<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="#">{{config('app.name_short')}}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="#">SP</a>
    </div>
    <ul class="sidebar-menu">
      @if (Auth::user()->role == 'USER')

        <li class="menu-header">Dashboard</li>
        <li><a class="nav-link" href="{{ route('user.dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

      @endif

      @if (Auth::user()->role == 'ADMIN')

        <li class="menu-header">Dashboard</li>
        <li class="{{ request()->is('admin') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
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
        <li class="{{ request()->is('dokter') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dokter.dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
        </li>
        <li class="menu-header">Data Master</li>
        <li class="{{ request()->is('dokter/penyakit*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ url('dokter/penyakit') }}">
            <i class="fas fa-book"></i> <span>Penyakit</span>
          </a>
        </li>
        <li class="{{ request()->is('dokter/gejala*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('gejala.index') }}">
            <i class="fas fa-book"></i> <span>Gejala</span>
          </a>
        </li>
        <li class="{{ request()->is('dokter/analisis*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('analisis.index') }}">
            <i class="fas fa-book"></i> <span>Analisis</span>
          </a>
        </li>
        <li class="{{ request()->is('dokter/penangananpenyakit*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('penangananpenyakit.index') }}">
            <i class="fas fa-book"></i> <span>Penanganan Penyakit</span>
          </a>
        </li>
        <li class="{{ request()->is('dokter/saya') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('doktersaya') }}">
            <i class="fas fa-book"></i> <span>Data Saya</span>
          </a>
        </li>
        <li class="{{ request()->is('dokter/jadwal*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('jadwal.index') }}">
            <i class="fas fa-book"></i> <span>Jadwal Saya</span>
          </a>
        </li>

      @endif

      </ul>

  </aside>
</div>