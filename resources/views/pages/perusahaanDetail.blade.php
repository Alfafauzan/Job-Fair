@extends('layouts.app')

@section('content')
    {{-- 
    Semua gaya (background, font, warna, bayangan) kini berada di dalam atribut "style" 
    pada setiap tag div, h2, p, img, dll.
--}}

    <div style="background-color: #f8f9fa; font-family: 'Inter', sans-serif; padding: 2rem 0;">
        <div class="container" style="max-width: 960px;">

            <div class="d-flex align-items-center flex-column flex-md-row text-center text-md-start gap-4 mb-4"
                style="background-color: #ffffff; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 2rem;">

                <div class="logo-wrapper">
                    {{-- Logo Perusahaan dengan Fallback Placeholder --}}
                    <img src="{{ asset('storage/foto_user/' . $datapur->foto) }}" alt="Logo {{ $datapur->nama }}"
                        style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #ffffff; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);"
                        onerror="this.onerror=null; this.src='https://placehold.co/120x120/EBF4FF/7F9CF5?text={{ substr($datapur->nama, 0, 1) }}';">
                </div>

                <div class="profile-header-info">
                    <h2 class="mb-1" style="font-weight: 700; color: #212529;">{{ $datapur->nama }}</h2>
                    <p class="text-muted mb-0">Profil Perusahaan</p>
                </div>
            </div>

            <div class="mb-4"
                style="background-color: #ffffff; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 2rem;">

                <h5
                    style="font-weight: 600; color: #0d6efd; border-bottom: 2px solid #dee2e6; padding-bottom: 0.75rem; margin-bottom: 1.5rem;">
                    Tentang Perusahaan
                </h5>
                <p class="text-secondary" style="line-height: 1.8;">
                    {{ $datapur->detailUser->deskripsi_pribadi ?? 'Informasi tentang perusahaan belum ditambahkan.' }}
                </p>
            </div>

            <div
                style="background-color: #ffffff; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 2rem;">

                <h5
                    style="font-weight: 600; color: #0d6efd; border-bottom: 2px solid #dee2e6; padding-bottom: 0.75rem; margin-bottom: 1.5rem;">
                    Hubungi Kami
                </h5>

                <div class="d-flex flex-column gap-3">

                    {{-- Alamat --}}
                    <div class="d-flex align-items-start" style="gap: 1rem;">
                        <div style="font-size: 1.25rem; color: #6c757d; flex-shrink: 0; width: 30px; text-align: center;">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <strong>Alamat</strong><br>
                            <span class="text-secondary">{{ $datapur->detailUser->alamat ?? 'Alamat belum diatur' }}</span>
                        </div>
                    </div>

                    {{-- Nomor Telepon --}}
                    <div class="d-flex align-items-start" style="gap: 1rem;">
                        <div style="font-size: 1.25rem; color: #6c757d; flex-shrink: 0; width: 30px; text-align: center;">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <strong>Nomor Telepon</strong><br>
                            <span
                                class="text-secondary">{{ $datapur->detailUser->noTlp ?? 'Nomor telepon belum diatur' }}</span>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="d-flex align-items-start" style="gap: 1rem;">
                        <div style="font-size: 1.25rem; color: #6c757d; flex-shrink: 0; width: 30px; text-align: center;">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div>
                            <strong>Email</strong><br>
                            <span class="text-secondary">{{ $datapur->email ?? 'Email belum diatur' }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- PENTING: Pastikan Anda tetap memuat Bootstrap CSS & JS serta Bootstrap Icons --}}
    {{-- Link di bawah ini diperlukan agar ikon (bi-geo-alt-fill, dll.) dapat tampil --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> --}}
@endsection
