@extends('layouts.app')

@section('content')

    {{-- 
PENTING: Pengecualian untuk "Active Tab"
Gaya untuk ".active" pada tombol tab navigasi tidak bisa diletakkan secara inline karena
kelas ".active" ditambahkan dan dihapus oleh JavaScript. Inline style tidak bisa merespon
perubahan kelas seperti ini. Oleh karena itu, blok kecil ini diperlukan agar fungsionalitas
tab tetap berjalan dengan benar.
--}}
    <style>
        .tab-link-custom.active {
            background-color: #e9ecef;
            /* Warna latar saat aktif */
            color: #0d6efd !important;
            font-weight: 600;
        }
    </style>


    @if (session('success_profile') || session('success_pengalaman'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success_profile') ?? session('success_pengalaman') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Wrapper utama dengan latar belakang dan font --}}
    <div style="background-color: #f8f9fa;">
        <div class="container py-4 py-md-5">

            {{-- HEADER PROFIL --}}
            <div class="d-flex flex-column flex-md-row align-items-center gap-4 p-4 mb-4 shadow-sm"
                style="background: white; border-radius: 0.75rem;">
                <img class="rounded-circle" src="{{ asset('storage/foto_user/' . Auth::user()->foto) }}"
                    alt="Profile Picture" style="width: 100px; height: 100px; object-fit: cover; border: 4px solid #fff;"
                    onerror="this.onerror=null; this.src='https://placehold.co/100x100/EBF4FF/7F9CF5?text={{ substr(Auth::user()->nama, 0, 1) }}';">
                <div class="text-center text-md-start">
                    <h2 class="h4 fw-bold mb-0">{{ Auth::user()->nama }}</h2>
                    <p class="text-muted mb-0">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
                @if (Auth::user()->role === 'pelamar')
                    <div class="ms-md-auto">
                        <button onclick="showSection('editProfilSection')"
                            class="btn btn-outline-primary rounded-pill px-4">
                            <i class="bi bi-pencil-fill me-1"></i> Edit Profil
                        </button>
                    </div>
                @endif
            </div>

            {{-- NAVIGASI TAB --}}
            <div class="d-flex justify-content-center align-items-center gap-2 gap-md-3 border-bottom pb-3 mb-4">
                <button onclick="showSection('profilSection')" id="btn-profil" class="tab-link-custom active"
                    style="padding: 0.5rem 1.5rem; border-radius: 50rem; font-weight: 500; border: none; background-color: transparent; color: #6c757d;">
                    Profil
                </button>
                @if (Auth::user()->role === 'pelamar')
                    <button onclick="showSection('statusSection')" id="btn-status" class="tab-link-custom"
                        style="padding: 0.5rem 1.5rem; border-radius: 50rem; font-weight: 500; border: none; background-color: transparent; color: #6c757d;">
                        Status Lamaran
                    </button>
                @endif
            </div>


            {{-- ====================================================== --}}
            {{-- SECTION: PROFIL PENGGUNA (DEFAULT TAMPIL) --}}
            {{-- ====================================================== --}}
            <div id="profilSection">
                <div class="row g-4">
                    {{-- KOLOM KIRI: BIODATA & PENDIDIKAN --}}
                    <div class="col-lg-5">
                        <div class="card shadow-sm border-0 h-100" style="border-radius: 0.75rem;">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold mb-4">Informasi Pribadi</h5>
                                <dl class="row">
                                    <dt class="col-sm-5" style="font-weight: 600; color: #6c757d;">Bio</dt>
                                    <dd class="col-sm-7" style="color: #212529;">
                                        {{ Auth::user()->detailUser->deskripsi_pribadi ?? '-' }}</dd>

                                    <dt class="col-sm-5" style="font-weight: 600; color: #6c757d;">Alamat</dt>
                                    <dd class="col-sm-7" style="color: #212529;">
                                        {{ Auth::user()->detailUser->alamat ?? '-' }}</dd>

                                    <dt class="col-sm-5" style="font-weight: 600; color: #6c757d;">No Telepon</dt>
                                    <dd class="col-sm-7" style="color: #212529;">
                                        {{ Auth::user()->detailUser->noTlp ?? '-' }}</dd>

                                    <dt class="col-sm-5" style="font-weight: 600; color: #6c757d;">Kelahiran</dt>
                                    <dd class="col-sm-7" style="color: #212529;">
                                        {{ Auth::user()->detailUser->tempat_lahir ?? '' }}{{ Auth::user()->detailUser->tempat_lahir && Auth::user()->detailUser->tanggal_lahir ? ',' : '' }}
                                        {{ Auth::user()->detailUser->tanggal_lahir ? \Carbon\Carbon::parse(Auth::user()->detailUser->tanggal_lahir)->format('d F Y') : '-' }}
                                    </dd>

                                    <dt class="col-sm-5" style="font-weight: 600; color: #6c757d;">Jenis Kelamin</dt>
                                    <dd class="col-sm-7" style="color: #212529;">
                                        {{ Auth::user()->detailUser->jenis_kelamin ?? '-' }}</dd>

                                    <dt class="col-sm-5" style="font-weight: 600; color: #6c757d;">CV</dt>
                                    <dd class="col-sm-7" style="color: #212529;">
                                        @if (Auth::user()->detailUser && Auth::user()->detailUser->file_cv)
                                            <a href="{{ asset('storage/cv/' . Auth::user()->detailUser->file_cv) }}"
                                                target="_blank" class="text-decoration-none">
                                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Lihat CV
                                            </a>
                                        @else
                                            <span class="text-muted">Belum diunggah</span>
                                        @endif
                                    </dd>
                                </dl>

                                <hr>

                                <h5 class="card-title fw-bold mt-4 mb-4">Pendidikan</h5>
                                <dl class="row">
                                    <dt class="col-sm-5" style="font-weight: 600; color: #6c757d;">Tingkat</dt>
                                    <dd class="col-sm-7" style="color: #212529;">
                                        {{ Auth::user()->detailUser->tingkat_pendidikan ?? '-' }}</dd>
                                    <dt class="col-sm-5" style="font-weight: 600; color: #6c757d;">Institusi</dt>
                                    <dd class="col-sm-7" style="color: #212529;">
                                        {{ Auth::user()->detailUser->nama_instansi ?? '-' }}</dd>
                                    <dt class="col-sm-5" style="font-weight: 600; color: #6c757d;">Tahun Lulus</dt>
                                    <dd class="col-sm-7" style="color: #212529;">
                                        {{ Auth::user()->detailUser->tahun_lulus ?? '-' }}</dd>
                                    <dt class="col-sm-5" style="font-weight: 600; color: #6c757d;">Nilai Akhir</dt>
                                    <dd class="col-sm-7" style="color: #212529;">
                                        {{ Auth::user()->detailUser->nilai_akhir ?? '-' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: PENGALAMAN KERJA --}}
                    <div class="col-lg-7">
                        <div class="card shadow-sm border-0" style="border-radius: 0.75rem;">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold mb-4">Pengalaman Kerja</h5>
                                @if (!isset($pengalamans) || $pengalamans->isEmpty())
                                    <div class="text-center py-5">
                                        <i class="bi bi-briefcase-fill fs-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada pengalaman kerja ditambahkan.</p>
                                    </div>
                                @else
                                    <div class="d-flex flex-column gap-3">
                                        @foreach ($pengalamans as $exp)
                                            <div class="p-3 border rounded">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="fw-bold mb-0">{{ $exp->jabatan }}</h6>
                                                        <p class="mb-1 text-muted">{{ $exp->nama_perusahaan }}</p>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-sm btn-warning"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editExpModal{{ $exp->id }}">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </button>
                                                        <form action="{{ route('pengalaman.delete', $exp->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin hapus pengalaman ini?')"><i
                                                                    class="bi bi-trash-fill"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <small
                                                    class="text-muted fst-italic">{{ \Carbon\Carbon::parse($exp->tahun_masuk)->format('M Y') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($exp->tahun_keluar)->format('M Y') }}</small>
                                                <p class="mt-2 mb-1" style="font-size: 0.9rem;">
                                                    {{ $exp->deskripsi_pekerjaan }}</p>
                                                <div>
                                                    @foreach (explode(',', $exp->skil) as $skill)
                                                        <span
                                                            class="badge bg-success fw-normal">{{ trim($skill) }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            {{-- Modal Edit Pengalaman --}}
                                            <div class="modal fade" id="editExpModal{{ $exp->id }}" tabindex="-1"
                                                aria-labelledby="editExpModalLabel{{ $exp->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('pengalaman.edit', $exp->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Pengalaman</h5><button
                                                                    type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-2"><label class="form-label">Nama
                                                                        Perusahaan</label><input type="text"
                                                                        name="nama_perusahaan" class="form-control"
                                                                        value="{{ $exp->nama_perusahaan }}" required>
                                                                </div>
                                                                <div class="mb-2"><label
                                                                        class="form-label">Jabatan</label><input
                                                                        type="text" name="jabatan"
                                                                        class="form-control" value="{{ $exp->jabatan }}"
                                                                        required></div>
                                                                <div class="mb-2"><label
                                                                        class="form-label">Deskripsi</label>
                                                                    <textarea name="deskripsi_pekerjaan" class="form-control" rows="4">{{ $exp->deskripsi_pekerjaan }}</textarea>
                                                                </div>
                                                                <div class="mb-2"><label
                                                                        class="form-label">Skill</label>
                                                                    <textarea name="skil" class="form-control" rows="2">{{ $exp->skil }}</textarea>
                                                                </div>
                                                                <div class="mb-2"><label class="form-label">Jenis
                                                                        Pekerjaan</label><select name="tipe_pekerjaan"
                                                                        class="form-select">
                                                                        <option value="Freelance"
                                                                            {{ $exp->tipe_pekerjaan == 'Freelance' ? 'selected' : '' }}>
                                                                            Freelance</option>
                                                                        <option value="Full-Time"
                                                                            {{ $exp->tipe_pekerjaan == 'Full-Time' ? 'selected' : '' }}>
                                                                            Full-Time</option>
                                                                        <option value="Intern"
                                                                            {{ $exp->tipe_pekerjaan == 'Intern' ? 'selected' : '' }}>
                                                                            Intern</option>
                                                                    </select></div>
                                                            </div>
                                                            <div class="modal-footer"><button type="button"
                                                                    class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button><button
                                                                    type="submit" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ====================================================== --}}
                {{-- BAGIAN REKOMENDASI LOWONGAN --}}
                {{-- ====================================================== --}}
                <div class="mt-5">
                    <h3 class="fw-bold mb-4">⭐ Rekomendasi Untuk Anda</h3>

                    @if (isset($recommendedJobs) && $recommendedJobs->isNotEmpty())
                        <div class="row g-4">
                            @foreach ($recommendedJobs as $job)
                                <div class="col-lg-6">
                                    <div class="card shadow-sm border-0 h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <h5 class="card-title fw-bold">{{ $job->judul_lowongan }}</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted">
                                                        {{ $job->perusahaan->nama }}
                                                    </h6>
                                                    <p class="card-text small text-muted">
                                                        <i class="bi bi-geo-alt"></i> {{ $job->lokasi }}
                                                        <span class="mx-2">|</span>
                                                        <i class="bi bi-briefcase"></i> {{ $job->tipe_pekerjaan }}
                                                    </p>
                                                </div>
                                                <div>
                                                    {{-- PENTING: Ganti '#' dengan route detail lowongan Anda --}}
                                                    <a href="{{ route('statusjobs', $job->id) }}"
                                                        class="btn btn-outline-primary btn-sm">Detail</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="card shadow-sm border-0">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-emoji-frown fs-1 text-muted"></i>
                                <p class="mt-2 text-muted">Belum ada rekomendasi yang cocok untuk Anda saat ini. <br>Coba
                                    perbarui pengalaman kerja dan skill Anda.</p>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            {{-- ====================================================== --}}
            {{-- SECTION: STATUS LAMARAN (TERSEMBUNYI) --}}
            {{-- ====================================================== --}}
            <div id="statusSection" style="display: none;">
                <div class="card shadow-sm border-0" style="border-radius: 0.75rem;">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4">Status Lamaran Anda</h5>
                        <div class="d-flex flex-column gap-3">
                            @forelse($lamaran as $datalamaran)
                                <div class="d-flex align-items-center p-3 border rounded">
                                    <img src="{{ asset('storage/foto_user/' . $datalamaran->perusahaan->foto) }}"
                                        alt="Logo" class="rounded-circle me-3"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-0">{{ $datalamaran->lowongan->judul_lowongan }}</h6>
                                        <p class="mb-1 text-muted">{{ $datalamaran->perusahaan->nama }}</p>
                                    </div>
                                    <div class="text-end">
                                        @php
                                            $statusClass = 'bg-secondary';
                                            if ($datalamaran->status_lamaran == 'diterima') {
                                                $statusClass = 'bg-success';
                                            }
                                            if ($datalamaran->status_lamaran == 'ditolak') {
                                                $statusClass = 'bg-danger';
                                            }
                                        @endphp
                                        <a href="{{ route('statusjobs', $datalamaran->lowongan_id) }}"
                                            class="btn btn-sm text-white {{ $statusClass }}">{{ ucfirst($datalamaran->status_lamaran) }}</a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="bi bi-file-earmark-x fs-1 text-muted"></i>
                                    <p class="mt-2 text-muted">Anda belum pernah melamar pekerjaan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- ====================================================== --}}
            {{-- SECTION: EDIT PROFIL (TERSEMBUNYI) --}}
            {{-- ====================================================== --}}
            <div id="editProfilSection" style="display: none;">
                <div class="row g-4">
                    {{-- KOLOM KIRI: EDIT BIODATA --}}
                    <div class="col-lg-7">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold mb-4">Edit Profil dan Pendidikan</h5>
                                <form action="{{ route('profile.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" id="foto" name="foto" accept="image/*"
                                        class="d-none">

                                    <div class="d-flex align-items-center gap-3 mb-4">
                                        <img id="preview-foto"
                                            src="{{ asset('storage/foto_user/' . Auth::user()->foto) }}" alt="User"
                                            class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                        <div>
                                            <button type="button" id="triggerUpload"
                                                class="btn btn-sm btn-outline-secondary">Ganti Foto</button>
                                            <p class="small text-muted mb-0 mt-1">JPG, GIF atau PNG. Ukuran maks 1MB.</p>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-12"><label for="nama" class="form-label">Nama
                                                Lengkap</label><input type="text" id="nama" name="nama"
                                                class="form-control" value="{{ Auth::user()->nama }}" required></div>
                                        <div class="col-md-12"><label for="deskripsi_pribadi" class="form-label">Bio
                                                Singkat</label>
                                            <textarea id="deskripsi_pribadi" name="deskripsi_pribadi" rows="3" class="form-control">{{ Auth::user()->detailUser->deskripsi_pribadi ?? '' }}</textarea>
                                        </div>
                                        <div class="col-12"><label for="alamat" class="form-label">Alamat
                                                Lengkap</label><input type="text" id="alamat" name="alamat"
                                                class="form-control"
                                                value="{{ Auth::user()->detailUser->alamat ?? '' }}"></div>
                                        <div class="col-md-6"><label for="noTlp" class="form-label">No
                                                Telepon</label><input type="text" id="noTlp" name="noTlp"
                                                class="form-control" value="{{ Auth::user()->detailUser->noTlp ?? '' }}">
                                        </div>
                                        <div class="col-md-6"><label class="form-label">Jenis Kelamin</label>
                                            <div class="d-flex gap-4 pt-2">
                                                @foreach (['Laki-laki', 'Perempuan'] as $gender)
                                                    <div class="form-check"><input class="form-check-input"
                                                            type="radio" name="jenis_kelamin"
                                                            id="gender_{{ $gender }}" value="{{ $gender }}"
                                                            {{ (Auth::user()->detailUser->jenis_kelamin ?? '') == $gender ? 'checked' : '' }}><label
                                                            class="form-check-label"
                                                            for="gender_{{ $gender }}">{{ $gender }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-6"><label for="tempat_lahir" class="form-label">Tempat
                                                Lahir</label><input type="text" id="tempat_lahir" name="tempat_lahir"
                                                class="form-control"
                                                value="{{ Auth::user()->detailUser->tempat_lahir ?? '' }}"></div>
                                        <div class="col-md-6"><label for="tanggal_lahir" class="form-label">Tanggal
                                                Lahir</label><input type="date" id="tanggal_lahir"
                                                name="tanggal_lahir" class="form-control"
                                                value="{{ Auth::user()->detailUser->tanggal_lahir ?? '' }}"></div>
                                        <hr class="my-3">
                                        <div class="col-md-6"><label for="tingkat_pendidikan"
                                                class="form-label">Pendidikan Terakhir</label><select
                                                id="tingkat_pendidikan" class="form-select" name="tingkat_pendidikan">
                                                @foreach (['SMP', 'SMK/SMA', 'SARJANA(S1)', 'MAGISTER(S2)'] as $level)
                                                    <option value="{{ $level }}"
                                                        {{ (Auth::user()->detailUser->tingkat_pendidikan ?? '') == $level ? 'selected' : '' }}>
                                                        {{ $level }}</option>
                                                @endforeach
                                            </select></div>
                                        <div class="col-md-6"><label for="nama_instansi" class="form-label">Nama
                                                Institusi</label><input type="text" id="nama_instansi"
                                                name="nama_instansi" class="form-control"
                                                value="{{ Auth::user()->detailUser->nama_instansi ?? '' }}"></div>
                                        <div class="col-md-6"><label for="tahun_lulus" class="form-label">Tahun
                                                Lulus</label><input type="text" id="tahun_lulus" name="tahun_lulus"
                                                class="form-control"
                                                value="{{ Auth::user()->detailUser->tahun_lulus ?? '' }}"></div>
                                        <div class="col-md-6"><label for="nilai_akhir" class="form-label">Nilai
                                                Akhir/IPK</label><input type="number" step="0.01" id="nilai_akhir"
                                                name="nilai_akhir" class="form-control"
                                                value="{{ Auth::user()->detailUser->nilai_akhir ?? '' }}"></div>
                                        <div class="col-12"><label for="file_cv" class="form-label">Upload CV Baru
                                                (opsional)</label><input class="form-control" type="file"
                                                id="file_cv" name="file_cv">
                                            <div class="form-text">Kosongkan jika tidak ingin mengubah CV yang sudah ada.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 text-end"><button type="submit" class="btn btn-primary px-4">Simpan
                                            Perubahan</button></div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: TAMBAH PENGALAMAN --}}
                    <div class="col-lg-5">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold mb-4">Tambah Pengalaman Kerja</h5>
                                <form action="{{ route('pengalaman.add') }}" method="POST">
                                    @csrf
                                    <div id="job-list">
                                        <div class="job-item mb-3">
                                            <div class="mb-2"><label class="form-label">Jabatan</label><input
                                                    type="text" name="jobs[0][jabatan]" class="form-control" required>
                                            </div>
                                            <div class="mb-2"><label class="form-label">Nama Perusahaan</label><input
                                                    type="text" name="jobs[0][nama_perusahaan]" class="form-control"
                                                    required></div>
                                            <div class="row g-2 mb-2">
                                                <div class="col"><label class="form-label">Tgl. Masuk</label><input
                                                        type="date" name="jobs[0][tahun_masuk]" class="form-control"
                                                        required></div>
                                                <div class="col"><label class="form-label">Tgl. Keluar</label><input
                                                        type="date" name="jobs[0][tahun_keluar]" class="form-control"
                                                        required></div>
                                            </div>
                                            <div class="mb-2"><label class="form-label">Deskripsi</label>
                                                <textarea name="jobs[0][deskripsi_pekerjaan]" class="form-control" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-2"><label class="form-label">Skill (pisahkan
                                                    koma)</label><input type="text" name="jobs[0][skil]"
                                                    class="form-control" required></div>
                                        </div>
                                    </div>
                                    <div class="d-grid"><button type="submit" class="btn btn-primary">Simpan
                                            Pengalaman</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT --}}
    <script>
        function showSection(sectionId) {
            ['profilSection', 'statusSection', 'editProfilSection'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
            const sectionToShow = document.getElementById(sectionId);
            if (sectionToShow) sectionToShow.style.display = 'block';

            ['btn-profil', 'btn-status'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.remove('active');
            });

            if (sectionId === 'profilSection') {
                document.getElementById('btn-profil')?.classList.add('active');
            } else if (sectionId === 'statusSection') {
                document.getElementById('btn-status')?.classList.add('active');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            showSection('profilSection');
        });
    </script>

@endsection
