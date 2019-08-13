<nav class="navbar has-shadow">
    <div class="container">
        <div class="navbar-brand">

            <a class="navbar-item logo" href="{{ url('/') }}">
                <img src="img/logo.png" width="28" height="28">
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
                    <a class="navbar-item">
                        Dashboard
                    </a>

                    <a class="navbar-item">Barang Keluar</a>

                    <a class="navbar-item">Barang Masuk</a>

                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">Master</a>
                        <div class="navbar-dropdown">
                            <a class="navbar-item">Unit Kerja</a>
                            <a class="navbar-item">Satuan</a>
                            <a class="navbar-item">Kelompok Kegiatan</a>
                            <a class="navbar-item">Kelompok Barang</a>
                            <a class="navbar-item">Barang</a>
                            <a class="navbar-item">Rekanan</a>
                            <a class="navbar-item">Volume DPA</a>
                        </div>
                    </div>

                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">Sistem</a>
                        <div class="navbar-dropdown">
                            <a class="navbar-item">Instansi</a>
                            <a class="navbar-item">User</a>
                        </div>
                    </div>

                @endif
            </div>

            <div class="navbar-end">
                @if (Auth::guest())
                    <a class="navbar-item " href="{{ route('login') }}">Login</a>
                    <a class="navbar-item " href="{{ route('register') }}">Register</a>
                @else
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
