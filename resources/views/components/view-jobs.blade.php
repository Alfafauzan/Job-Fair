@extends('layouts.app')

@section('styles')
    {{-- Link Font Awesome & Bootstrap Icons (opsional, untuk ikon) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')

    <div style="background-color: #f8f9fa; font-family: 'Inter', sans-serif; padding: 3rem 0;">
        <div class="container">
            <div class="row g-4">
                {{-- KOLOM UTAMA (DETAIL LOWONGAN) --}}
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0" style="border-radius: 1rem;">
                        <div class="card-body p-4 p-md-5">
                            {{-- Judul dan Nama Perusahaan --}}
                            <h1 style="font-size: 2.25rem; font-weight: 700; color: #343a40;">{{ $data->judul_lowongan }}
                            </h1>
                            <p style="font-size: 1.1rem; color: #6c757d; margin: 5px 0 30px 0;">
                                {{ $data->perusahaan->nama }}</p>

                            {{-- Info Detail Lowongan --}}
                            <ul class="list-unstyled d-flex flex-column gap-3 mb-4">
                                <li class="d-flex align-items-center"><i
                                        class="bi bi-briefcase-fill me-3 fs-5 text-secondary"></i><span>{{ $data->tipe_pekerjaan }}</span>
                                </li>
                                <li class="d-flex align-items-center"><i
                                        class="bi bi-geo-alt-fill me-3 fs-5 text-secondary"></i><span>{{ $data->lokasi }}</span>
                                </li>
                                <li class="d-flex align-items-center"><i
                                        class="bi bi-tags-fill me-3 fs-5 text-secondary"></i>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($data->kategori_lowongan as $lowongan)
                                            <span
                                                class="badge bg-light text-dark border rounded-pill">{{ $lowongan }}</span>
                                        @endforeach
                                    </div>
                                </li>
                                <li class="d-flex align-items-center"><i
                                        class="bi bi-currency-dollar me-3 fs-5 text-secondary"></i><span>Rp.{{ number_format($data->gaji_minimum) }}
                                        - Rp.{{ number_format($data->gaji_maximum) }}</span></li>
                            </ul>

                            <hr>

                            {{-- Deskripsi Lowongan --}}
                            <div class="mt-4">
                                <h2
                                    style="font-size: 1.25rem; font-weight: 600; color: #343a40; border-bottom: 2px solid #dee2e6; padding-bottom: 8px; margin-bottom: 15px;">
                                    Deskripsi Lowongan</h2>
                                <p style="font-size: 1rem; line-height: 1.7; color: #555;">
                                    {!! nl2br(e($data->deskripsi_lowongan)) !!}
                                </p>
                            </div>

                            {{-- Kualifikasi --}}
                            <div class="mt-4">
                                <h2
                                    style="font-size: 1.25rem; font-weight: 600; color: #343a40; border-bottom: 2px solid #dee2e6; padding-bottom: 8px; margin-bottom: 15px;">
                                    Kualifikasi</h2>
                                <div style="font-size: 1rem; line-height: 1.7; color: #555;">
                                    {!! nl2br(e($data->kualifikasi)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM SISI KANAN (INFORMASI PERUSAHAAN & TOMBOL) --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0" style="border-radius: 1rem;">
                        <div class="card-body p-4 text-center">
                            <img src="{{ asset('storage/foto_user/' . $data->perusahaan->foto) }}"
                                alt="Logo {{ $data->perusahaan->nama }}"
                                style="width: 80px; height: 80px; object-fit: contain; margin-bottom: 1rem;">
                            <h5 class="fw-bold">{{ $data->perusahaan->nama }}</h5>

                            <div class="d-grid gap-2 mt-4">
                                @if (!Auth::check())
                                    <a href="/login" class="btn btn-primary btn-lg">Login untuk Melamar</a>
                                @elseif (Auth::user()->role === 'pelamar')
                                    @if ($chek === null)
                                        <button class="btn btn-primary btn-lg" data-bs-toggle="modal"
                                            data-bs-target="#lamarModal">
                                            Lamar Pekerjaan Ini
                                        </button>
                                    @else
                                        <button class="btn btn-success btn-lg" disabled>
                                            <i class="bi bi-check-circle-fill me-2"></i>Anda Sudah Melamar
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DAFTAR PELAMAR (Hanya tampil untuk perusahaan) --}}
            @if (Auth::check() && Auth::user()->role === 'perusahaan')
                <div class="mt-5">
                    <h2 style="font-size: 1.75rem; font-weight: 600; margin-bottom: 1.5rem; color: #343a40;">Daftar Pelamar
                    </h2>

                    @forelse ($data_pelamar as $pelamar)
                        <div class="card shadow-sm border-0 mb-3" style="border-radius: 0.75rem;">
                            <div class="card-body p-3">
                                <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                                    {{-- Profile --}}
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <img src="{{ asset('storage/foto_user/' . $pelamar->pelamar->foto) }}"
                                            alt="Foto Pelamar"
                                            style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #dee2e6;">
                                        <div class="ms-3">
                                            <h6 class="fw-bold mb-0">{{ $pelamar->pelamar->nama }}</h6>
                                            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                                {{ Str::limit($pelamar->pelamar_deskripsi, 70) }}</p>
                                        </div>
                                    </div>
                                    {{-- Actions --}}
                                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0 applicant-actions"
                                        style="flex-shrink: 0;">
                                        <a href="{{ asset('storage/file_cv/' . $pelamar->file_cv) }}" download
                                            class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-file-alt me-1"></i> CV
                                        </a>
                                        @if ($pelamar->status_lamaran === 'pending')
                                            <button class="btn btn-success btn-sm btn-status" data-id="{{ $pelamar->id }}"
                                                data-status="diterima">
                                                <i class="fas fa-check"></i> Terima
                                            </button>
                                            <button class="btn btn-danger btn-sm btn-status" data-id="{{ $pelamar->id }}"
                                                data-status="ditolak">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        @else
                                            <button
                                                class="btn btn-sm {{ $pelamar->status_lamaran === 'diterima' ? 'btn-success' : 'btn-danger' }}"
                                                disabled>
                                                {{ ucfirst($pelamar->status_lamaran) }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card shadow-sm border-0">
                            <div class="card-body text-center p-5">
                                <p class="text-muted">Belum ada pelamar untuk lowongan ini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            @endif

        </div>
    </div>

    {{-- MODAL LAMAR PEKERJAAN --}}
    <div class="modal fade" id="lamarModal" tabindex="-1" aria-labelledby="lamarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('lamar.lowongan') }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
                @csrf
                <input type="hidden" value="{{ $data->perusahaan->id }}" name="perusahaan_id">
                <input type="hidden" value="{{ $data->id }}" name="lowongan_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="lamarModalLabel">Lamar Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Anda melamar sebagai <strong>{{ Auth::user()->nama ?? '' }}</strong> untuk posisi
                        <strong>{{ $data->judul_lowongan }}</strong>.
                    </p>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Opsi CV</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cv_option" id="use_existing_cv"
                                value="existing" checked>
                            <label class="form-check-label" for="use_existing_cv">Gunakan CV yang sudah ada di
                                profil</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cv_option" id="upload_new_cv"
                                value="upload">
                            <label class="form-check-label" for="upload_new_cv">Upload CV Baru</label>
                        </div>
                    </div>
                    <div class="mb-3" id="upload_cv_field" style="display: none;">
                        <label for="file_cv" class="form-label">Upload CV Baru (PDF, maks 2MB)</label>
                        <input type="file" class="form-control" name="file_cv" id="file_cv">
                    </div>
                    <div class="mb-3">
                        <label for="resume" class="form-label">Pesan Tambahan (Opsional)</label>
                        <textarea class="form-control" name="pelamar_deskripsi" id="resume" rows="4"
                            placeholder="Tulis pesan singkat atau perkenalan diri..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
                </div>
            </form>
        </div>
    </div>

@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadRadio = document.getElementById('upload_new_cv');
        const existingRadio = document.getElementById('use_existing_cv');
        const uploadField = document.getElementById('upload_cv_field');

        function toggleCVUpload() {
            if (uploadField) {
                uploadField.style.display = uploadRadio.checked ? 'block' : 'none';
            }
        }

        uploadRadio?.addEventListener('change', toggleCVUpload);
        existingRadio?.addEventListener('change', toggleCVUpload);
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-status').click(function() {
            let lamaranId = $(this).data('id');
            let status = $(this).data('status');
            let button = $(this);

            $.ajax({
                url: '/lamaran/update-status/' + lamaranId, // Pastikan route ini benar
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    alert('Status berhasil diperbarui ke: ' + status);
                    // Update UI tanpa reload halaman
                    button.closest('.applicant-actions').html(
                        `<button class="btn btn-sm ${status === 'diterima' ? 'btn-success' : 'btn-danger'}" disabled>${status.charAt(0).toUpperCase() + status.slice(1)}</button>`
                    );
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat memperbarui status.');
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
