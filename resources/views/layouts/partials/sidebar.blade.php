<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link bg-primary">
        <img src="{{ $setting->url_logo }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3 bg-light"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ $setting->nama_apotek }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <a href="{{ route('user.profil') }}" class="user-panel d-flex my-2 pb-2">
            <div class="image my-auto">
                <img src="{{ auth()->user()->url_foto }}" class="img-circle user-photo" alt="User Image">
            </div>
            <div class="info flex-grow-1">
                <span class="d-block user-name">{{ auth()->user()->name }}</span>
                <span class="badge badge-info rounded-pill font-weight-normal px-2"
                    style="padding-bottom: .35rem;">{{ auth()->user()->role }}</span>
            </div>
            <div class="my-auto">
                <i class="fas fa-edit text-primary my-auto ml-3 text-sm"></i>
            </div>
        </a>

        <!-- Sidebar Menu -->
        <nav class="my-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @if (auth()->user()->hasRole('admin'))
                    <li class="nav-header">Menu Master</li>
                    <li class="nav-item">
                        <a href="{{ route('kategori.index') }}"
                            class="nav-link {{ request()->is('kategori') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>Data Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('obat.index') }}"
                            class="nav-link {{ request()->is('obat') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pills"></i>
                            <p>Data Obat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('satuan.index') }}"
                            class="nav-link {{ request()->is('satuan') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Data Satuan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('supplier.index') }}"
                            class="nav-link {{ request()->is('supplier') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>Data Supplier</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('member.index') }}"
                            class="nav-link {{ request()->is('member') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-id-card"></i>
                            <p>Data Member</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}"
                            class="nav-link {{ request()->is('user') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Pengguna</p>
                        </a>
                    </li>

                    <li class="nav-header">Menu Transaksi</li>
                    <li class="nav-item">
                        <a href="{{ route('penjualan.index') }}"
                            class="nav-link {{ request()->is('penjualan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Penjualan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pembelian.index') }}"
                            class="nav-link {{ request()->is('pembelian*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Pembelian</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pengeluaran.index') }}"
                            class="nav-link {{ request()->is('pengeluaran') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>Pengeluaran</p>
                        </a>
                    </li>

                    <li class="nav-header">Menu Lainnya</li>

                    <li class="nav-item">
                        <a href="{{ route('stok-opname') }}"
                            class="nav-link {{ request()->is('stock-opname') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-check"></i>
                            <p>Stock Opname</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('laporan.index') }}"
                            class="nav-link {{ request()->is('laporan') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Laporan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('setting.index') }}"
                            class="nav-link {{ request()->is('setting') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Pengaturan</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
