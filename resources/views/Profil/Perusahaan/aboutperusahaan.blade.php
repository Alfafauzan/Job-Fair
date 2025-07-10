@extends('layouts.app')

@section('content')
    <style>
        /* Latar belakang utama halaman */
        .profile-page-bg {
            background-color: #f8f9fa;
        }

        /* Kartu header profil */
        .profile-header-card {
            background: white;
            border-radius: 0.75rem;
            border: 1px solid #dee2e6;
        }

        .profile-picture {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 4px solid #e9ecef;
        }

        /* Kustomisasi Nav Pills (Pengganti Tab Manual) */
        .nav-pills .nav-link {
            border-radius: 50rem;
            font-weight: 500;
            color: #6c757d;
            padding: 0.6rem 1.5rem;
        }

        .nav-pills .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
        }

        /* Kartu konten utama */
        .profile-content-card {
            border-radius: 0.75rem;
            border: 1px solid #dee2e6;
            background-color: white;
        }

        /* Detail list di kontak */
        .contact-details dt {
            font-weight: 600;
            color: #495057;
        }

        .contact-details dd {
            color: #6c757d;
        }

        /* Atur iframe peta agar responsif dan tidak merusak layout */
        .map-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>

    @if (session('success_lowongan'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success_lowongan') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Wrapper utama dengan latar belakang --}}
    <div class="profile-page-bg">
        <div class="container py-4 py-md-5">

            {{-- HEADER PROFIL --}}
            <div class="profile-header-card d-flex flex-column flex-md-row align-items-center gap-4 p-4 mb-4">
                <img class="rounded-circle profile-picture" src="{{ asset('storage/foto_user/' . Auth::user()->foto) }}"
                    alt="Profile Picture"
                    onerror="this.onerror=null; this.src='https://placehold.co/100x100/EBF4FF/7F9CF5?text={{ substr(Auth::user()->nama, 0, 1) }}';">
                <div class="text-center text-md-start">
                    <h2 class="h4 fw-bold mb-0">{{ Auth::user()->nama }}</h2>
                    <p class="text-muted mb-0">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
                @if (Auth::user()->role === 'perusahaan')
                    <div class="ms-md-auto">
                        <a href="/editprofil-perusahaan" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="bi bi-pencil-fill me-1"></i> Edit Profil
                        </a>
                    </div>
                @endif
            </div>

            {{-- NAVIGASI TAB MENGGUNAKAN BOOTSTRAP NAV-PILLS --}}
            <ul class="nav nav-pills justify-content-center gap-2 gap-md-3 mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-about-tab" data-bs-toggle="pill" data-bs-target="#pills-about"
                        type="button" role="tab" aria-controls="pills-about" aria-selected="true">Tentang</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-joblist-tab" data-bs-toggle="pill" data-bs-target="#pills-joblist"
                        type="button" role="tab" aria-controls="pills-joblist" aria-selected="false">Daftar
                        Lowongan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact"
                        type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Kontak</button>
                </li>
            </ul>

            {{-- KONTEN TAB --}}
            <div class="tab-content" id="pills-tabContent">

                {{-- ====================================================== --}}
                {{-- SECTION: TENTANG PERUSAHAAN (DEFAULT TAMPIL) --}}
                {{-- ====================================================== --}}
                <div class="tab-pane fade show active" id="pills-about" role="tabpanel" aria-labelledby="pills-about-tab">
                    <div class="profile-content-card">
                        <div class="card-body p-4 p-md-5">
                            <h5 class="card-title fw-bold mb-3">Deskripsi Perusahaan</h5>
                            <p class="text-body-secondary">
                                {{ Auth::user()->detailUser->deskripsi_pribadi ?? 'Deskripsi belum ditambahkan.' }}
                            </p>

                            <hr class="my-4">

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h5 class="card-title fw-bold mb-3">Visi</h5>
                                    <p class="text-body-secondary">
                                        {{ Auth::user()->detailUser->visi ?? 'Visi belum ditambahkan.' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="card-title fw-bold mb-3">Misi</h5>
                                    <p class="text-body-secondary">
                                        {{ Auth::user()->detailUser->misi ?? 'Misi belum ditambahkan.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ====================================================== --}}
                {{-- SECTION: DAFTAR LOWONGAN --}}
                {{-- ====================================================== --}}
                <div class="tab-pane fade" id="pills-joblist" role="tabpanel" aria-labelledby="pills-joblist-tab">
                    <x-joblist></x-joblist>
                </div>

                {{-- ====================================================== --}}
                {{-- SECTION: KONTAK --}}
                {{-- ====================================================== --}}
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="row g-4">
                        {{-- KOLOM KIRI: INFO KONTAK --}}
                        <div class="col-lg-5">
                            <div class="profile-content-card ">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-bold mb-4">Informasi Kontak</h5>
                                    <dl class="contact-details row g-3">
                                        <dt class="col-1"><i class="bi bi-envelope-fill"></i></dt>
                                        <dd class="col-11">{{ Auth::user()->email }}</dd>

                                        <dt class="col-1"><i class="bi bi-telephone-fill"></i></dt>
                                        <dd class="col-11">{{ Auth::user()->detailUser->noTlp ?? 'Belum dilengkapi' }}</dd>

                                        <dt class="col-1"><i class="bi bi-geo-alt-fill"></i></dt>
                                        <dd class="col-11">{{ Auth::user()->detailUser->alamat ?? 'Belum dilengkapi' }}
                                        </dd>
                                    </dl>
                                    @if (Auth::user()->detailUser && Auth::user()->detailUser->website)
                                        <a href="{{ Auth::user()->detailUser->website }}" target="_blank"
                                            class="btn btn-primary mt-4 w-100">
                                            <i class="bi bi-box-arrow-up-right me-2"></i>Kunjungi Website
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- KOLOM KANAN: PETA --}}
                        <div class="col-lg-7">
                            <div class="profile-content-card h-100">
                                <div class="card-body p-3">
                                    <h5 class="card-title fw-bold mb-3 px-1">Lokasi Kami</h5>
                                    <div class="map-container position-relative" style="padding-bottom: 75%;"> {/* Aspect
                                        Ratio 4:3 */}
                                        @if (Auth::user()->detailUser && Auth::user()->detailUser->link_maps)
                                            {!! Auth::user()->detailUser->link_maps !!}
                                        @else
                                            <div
                                                class="d-flex align-items-center justify-content-center bg-light h-100 position-absolute top-0 start-0 w-100">
                                                <p class="text-muted">Peta belum ditambahkan.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
