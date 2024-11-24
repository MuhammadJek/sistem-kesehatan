<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Sistem Kesehatan</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Route::is('dashboard') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

            <li class="menu-header">Master</li>
            <li class="{{ Route::is('barang.*') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ Route('barang.index') }}"><i class="fas fa-box"></i>
                    <span>Barang</span></a></li>
            <li class="{{ Route::is('supplier.*') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ Route('supplier.index') }}"><i class="fas fa-people-carry"></i>
                    <span>Supplier</span></a></li>

            <li class="{{ Route::is('transaksi.*') || Route::is('detail.transaksi') ? 'active' : '' }}"><a
                    class="nav-link" href="{{ Route('transaksi.index') }}"><i class="fas fa-shopping-cart"></i>
                    <span>Pembelian</span></a></li>
            <li class="{{ Route::is('stock.*') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ Route('stock.index') }}"><i class="fas fa-box-open"></i>
                    <span>Stock</span></a></li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn btn-primary btn-lg btn-block
                btn-icon-split">
                <i class="fas fa-rocket"></i> Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>
</div>
