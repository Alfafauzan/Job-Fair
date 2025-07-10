@extends('layouts.app')

@section('content')
    <div class="container py-4">
        {{-- Notifikasi Alert --}}
        @foreach ([
            'success_profile' => ['type' => 'success', 'title' => 'Berhasil!', 'icon' => 'check-circle'],
            'success_lowongan' => ['type' => 'success', 'title' => 'Berhasil!', 'icon' => 'check-circle'],
            'fails_lowongan' => ['type' => 'danger', 'title' => 'Gagal!', 'icon' => 'exclamation-triangle'],
        ] as $key => $alert)
            @if (session($key))
                <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show d-flex align-items-center"
                    role="alert">
                    <i class="bi bi-{{ $alert['icon'] }} me-2 fs-5"></i>
                    <div>
                        <strong>{{ $alert['title'] }}</strong> {{ session($key) }}
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endforeach




        {{-- Tombol Kembali (Posisi Baru) --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ Auth::user()->role === 'pelamar' ? '/profilPelamar' : '/about-perusahaan' }}"
                class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
            <h2 class="h4 mb-0 text-white">Edit Profil Perusahaan</h2>
        </div>

        <div class="card shadow-sm" style="background-color: #ffffff10; border: none;">
            <div class="card-header bg-transparent border-bottom">
                {{-- Navigasi Tab --}}
                <div class="d-flex justify-content-start align-items-center border-bottom-0">
                    <a href="#" onclick="showTab('edit-profile')" class="nav-link px-4 py-2"
                        id="tab-edit-profile">Profil Utama</a>
                    <a href="#" onclick="showTab('about')" class="nav-link px-4 py-2" id="tab-about">Tentang</a>
                    <a href="#" onclick="showTab('post-job')" class="nav-link px-4 py-2" id="tab-post-job">Buat
                        Lowongan</a>
                </div>
            </div>
            <div class="card-body p-4">
                {{-- Konten Tab Anda --}}
                <div id="section-edit-profile" class="tab-section">
                    <div class="edit-profile-container position-relative">
                        <div class="d-flex align-items-center mb-4">
                            <img src="{{ asset('storage/foto_user/' . Auth::user()->foto) }}" class="rounded-circle me-3"
                                width="80" height="80" alt="Photo" id="showphoto">
                            <button type="button" class="btn btn-primary btn-sm" id="btn_foto">Change Photo</button>
                        </div>
                        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="companyName" class="form-label text-white">Company Name</label>
                                    <input type="text" class="form-control" id="companyName"
                                        placeholder="Enter you compny name" value="{{ Auth::user()->nama }}" name="nama">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label text-white">Email</label>
                                    <input type="email" class="form-control" id="email"
                                        placeholder="Enter your company email" name="email"
                                        value="{{ Auth::user()->email }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="address" class="form-label text-white">Company Address</label>
                                    <input type="text" class="form-control" id="address"
                                        placeholder="Enter your company addreas" name="alamat"
                                        value="{{ Auth::user()->detailUser->alamat ?? 'belum di lengkapi' }}">
                                </div>
                                <input type="file" id="foto_input" name="foto" accept="image/*" class="d-none">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label text-white">Phone Number</label>
                                    <input type="text" class="form-control" id="phone"
                                        placeholder="Enter your company no phone" name="noTlp"
                                        value="{{ Auth::user()->detailUser->noTlp ?? 'belum di lengkapi' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="website" class="form-label text-white">Website</label>
                                    <input type="text" class="form-control" id="website"
                                        placeholder="Enter your company link website" name="website"
                                        value="{{ Auth::user()->detailUser->website ?? 'belum di lengkapi' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="website" class="form-label text-white">Link Embed Maps</label>
                                    <input type="text" class="form-control" id="website"
                                        placeholder="Enter your company link embed maps" name="link_maps"
                                        value="{{ Auth::user()->detailUser->link_maps ?? 'belum di lengkapi' }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success px-4 py-2 mt-3">
                                <i class="bi bi-save me-2"></i> Simpan Profil
                            </button>

                        </form>
                    </div>
                </div>

                <div id="section-about" class="tab-section d-none">
                    <!-- About Section -->
                    <div class="edit-profile-container position-relative">
                        <h2>About Company</h2>
                        <hr>

                        <form action="{{ route('profile.update') }}" method="post">
                            @csrf
                            <div class="kolom mb-3">
                                <label for="Descripsi-perusahaan" class="form-label text-white">Deskripsi
                                    Perusahaan</label>
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"
                                    name="deskripsi_pribadi">{{ Auth::user()->detailUser->deskripsi_pribadi ?? 'belum di lengkapi' }}</textarea>
                            </div>
                            <div class="kolom mb-3">
                                <label for="visi-perusahaan" class="form-label text-white">Visi</label>
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"
                                    name="visi">{{ Auth::user()->detailUser->visi ?? 'belum di lengkapi' }}</textarea>
                            </div>
                            <div class="kolom mb-3">
                                <label for="misi-perusahaan" class="form-label text-white">Misi</label>
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"
                                        name="misi">{{ Auth::user()->detailUser->misi ?? 'belum di lengkapi' }}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success px-4 py-2 mt-3">
                                <i class="bi bi-save me-2"></i> Simpan Informasi
                            </button>

                        </form>
                    </div>
                </div>

                <div id="section-post-job" class="tab-section d-none">
                    <x-PostJob></x-PostJob>
                </div>
            </div>
        </div>
    </div>


    <!-- JavaScript untuk tab switching -->
    <script>
        function showTab(tabId) {
            const sections = document.querySelectorAll('.tab-section');
            const tabs = document.querySelectorAll('.nav-link');

            sections.forEach(section => {
                section.classList.add('d-none');
            });

            tabs.forEach(tab => {
                tab.classList.remove('text-primary', 'border-bottom', 'border-primary', 'fw-bold');
                tab.classList.add('text-dark');
            });

            document.getElementById(`section-${tabId}`).classList.remove('d-none');
            document.getElementById(`tab-${tabId}`).classList.add('text-primary', 'border-bottom', 'border-primary',
                'fw-bold');
        }

        // Default tab saat load halaman
        document.addEventListener('DOMContentLoaded', () => {
            showTab('edit-profile');
        });
    </script>

    <script>
        document.getElementById('btn_foto').addEventListener('click', function() {
            document.getElementById('foto_input').click();
        });
        document.getElementById('foto_input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const photoPreview = document.getElementById('showphoto');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                alert("Silakan pilih file gambar.");
                this.value = '';
            }
        });
    </script>
@endsection
