@extends('layouts.app')

@section('content')
    {{-- Pencarian --}}
    <x-pencarian variant="perusahaan" />

    {{-- List Perusahaan --}}
    <div class="container mt-5">
        <div class="popular-categories">
            <h2 class="mb-4">Daftar Perusahaan</h2>
            <div class="row g-4">
                @foreach ($datapr as $perusahaan)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm text-center" style="cursor: pointer;"
                            onclick="goToPerusahaan('{{ $perusahaan->id }}')">
                            <div class="card-body d-flex flex-column align-items-center">
                                <img src="{{ asset('storage/foto_user/' . $perusahaan->foto) }}" alt="perusahaan"
                                    class="img-fluid mb-3" style="max-height: 100px; object-fit: contain;">
                                <h5 class="card-title">{{ $perusahaan->nama }}</h5>
                                <p class="card-text text-muted">Jakarta, Indonesia</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function goToPerusahaan(id) {
            window.location.href = `/perusahaandetail/${id}`;
        }
    </script>
@endsection
