<nav class="navbar is-light">
    <div class="container">
        <div class="navbar-brand">

            <a class="navbar-item logo" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" width="28" height="28">
                <span>{{ config('app.name', 'Laravel') }}</span>
            </a>

            <div class="navbar-burger burger" data-target="navMenu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <div class="navbar-menu" id="navMenu">
            <div class="navbar-start">
                @if (Auth::user())
                        <a class="navbar-item" href="/home">Dashboard</a>
                    @if (auth()->user()->can('barang keluar'))
                        <a class="navbar-item" href="/barang-keluar/board">Barang Keluar</a>
                    @endif
                    @if (auth()->user()->can('barang masuk'))
                        <a class="navbar-item" href="/barang-masuk/board">Barang Masuk</a>
                    @endif
                    @if (auth()->user()->can('master'))
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link">Master</a>
                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="/unit-kerja/board">Unit Kerja</a>
                                <a class="navbar-item" href="/satuan/board">Satuan</a>
                                <a class="navbar-item" href="/kelompok-kegiatan/board">Kelompok Kegiatan</a>
                                <a class="navbar-item" href="/kelompok-barang/board">Kelompok Barang</a>
                                <a class="navbar-item" href="/barang/board">Barang</a>
                                <a class="navbar-item" href="/perusahaan/board">Rekanan</a>
                                <a class="navbar-item" href="/volume-dpa/board">Volume DPA</a>
                            </div>
                        </div>
                    @endif
                    @if (auth()->user()->can('instansi') || auth()->user()->can('user'))
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">Sistem</a>
                        <div class="navbar-dropdown">
                            @if (auth()->user()->can('instansi'))
                                <a class="navbar-item" href="/instansi">Instansi</a>
                            @endif
                            @if (auth()->user()->can('user'))
                                <a class="navbar-item" href="/users">User</a>
                            @endif
                        </div>
                    </div>
                    @endif
                @endif
            </div>

            <div class="navbar-end">
                @if (Auth::user())
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link" href="#">{{ Auth::user()->name }}</a>

                        <div class="navbar-dropdown">
                            <a class="navbar-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>
