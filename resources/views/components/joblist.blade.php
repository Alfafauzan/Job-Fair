<div id="joblistSection">
    {{-- @if (Auth::user()->role === 'perusahaan')
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" onclick="showPostJob()">+ Post New Job</button>
        </div>
    @endif --}}

    <div class="row">
        @foreach ($jobs as $datajobs)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class=" h-100 shadow-sm">
                    <div class="card-body d-flex">
                        <img src="{{ asset('storage/foto_user/' . $datajobs->perusahaan->foto) }}" alt="Company Logo"
                            class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                        <div>
                            <h6 class="mb-1">{{ $datajobs->perusahaan->nama }}</h6>
                            <h5 class="card-title mb-1">{{ $datajobs->judul_lowongan }}</h5>
                            <p class="card-text text-muted" style="font-size: 0.9rem;">
                                {{ Str::limit($datajobs->deskripsi_lowongan, 100) }}
                            </p>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 text-end">
                        {{-- TOMBOL LIHAT DETAIL --}}
                        <a href="{{ route('statusjobs', $datajobs->id) }}" class="btn btn-sm btn-outline-primary">Lihat
                            Pelamar</a>

                        {{-- FORM DAN TOMBOL HAPUS --}}
                        <form action="{{ route('lowongan.delete', $datajobs->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- <div id="postJobSection" style="display: none;">
    <x-PostJob></x-PostJob>
    <div class="mt-3">
        <button type="button" onclick="cancelPostJob()" class="btn btn-secondary">← Batal Posting</button>
    </div>
</div> --}}

<script>
    function showPostJob() {
        document.getElementById('joblistSection').style.display = 'none';
        document.getElementById('postJobSection').style.display = 'block';
    }

    function cancelPostJob() {
        document.getElementById('postJobSection').style.display = 'none';
        document.getElementById('joblistSection').style.display = 'block';
    }
</script>
