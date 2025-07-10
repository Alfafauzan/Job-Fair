<nav class="navbar navbar-expand-lg bg-body-white shadow-sm py-2">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand" href="/" id="homelink">
            <img src="{{ asset('images/wnn3.png') }}" alt="Logo Perusahaan" style="width: 180px; height: auto;">
        </a>

        {{-- Tombol Toggle untuk Mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            {{-- Link Navigasi Utama (di kiri) --}}
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lowongan') ? 'active' : '' }}"
                        href="{{ route('lowongan') }}" id="lowonganlink">Lowongan Kerja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs($navbarType . '.listPerusahaan') ? 'active' : '' }}"
                        href="{{ route($navbarType . '.listPerusahaan') }}">Perusahaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs($navbarType . '.tentangkami') ? 'active' : '' }}"
                        href="/tentangkami">Tentang Kami</a>
                </li>
            </ul>

            {{-- Bagian Kanan Navbar: Tombol atau Profil Pengguna --}}
            {{-- ms-auto akan mendorong semua item ini ke ujung kanan --}}
            <div class="navbar-nav ms-auto d-flex align-items-center">
                @guest
                    {{-- Tampilan untuk Pengguna yang Belum Login --}}
                    <div class="d-flex align-items-center gap-2">
                        <a href="/login" class="btn btn-masuk">Masuk</a>
                        <a href="/register" class="btn btn-perusahaan">Daftar</a>
                    </div>
                @else
                    {{-- Tampilan untuk Pengguna yang Sudah Login --}}
                    <div class="nav-item dropdown">
                        {{-- Toggle Dropdown dengan Gambar Profil --}}
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-decoration-none"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="rounded-circle" src="{{ asset('storage/foto_user/' . Auth::user()->foto) }}"
                                alt="Foto Profil" style="height: 40px; width: 40px; object-fit: cover;"
                                onerror="this.onerror=null; this.src='https://placehold.co/40x40/EBF4FF/7F9CF5?text={{ substr(Auth::user()->nama, 0, 1) }}';">
                            {{-- Menampilkan nama di samping foto (opsional, hanya di layar besar) --}}
                            <span class="d-none d-lg-inline fw-semibold">{{ Auth::user()->nama }}</span>
                        </a>

                        {{-- Menu Dropdown --}}
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="border-radius: 0.75rem;">
                            {{-- Menambahkan header dengan nama pengguna di dalam dropdown --}}
                            <li>
                                <h6 class="dropdown-header">Selamat Datang!</h6>
                            </li>

                            {{-- Link Profil (Struktur HTML diperbaiki dengan <li>) --}}
                            <li>
                                <a class="dropdown-item"
                                    href="{{ Auth::user()->role === 'pelamar' ? '/profilPelamar' : '/about-perusahaan' }}">
                                    <i class="bi bi-person-circle me-2"></i>Profile
                                </a>
                            </li>

                            {{-- Divider untuk pemisah visual --}}
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            {{-- Link Keluar (Struktur HTML diperbaiki dengan <li>) --}}
                            <li>
                                <a class="dropdown-item text-danger" href="/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                </a>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

{{-- PENTING: Untuk ikon di dropdown (opsional), pastikan Anda memuat Bootstrap Icons --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> --}}
