<div class="company-carousel">
    {{-- Header Carousel --}}
    <h2 style=" font-weight: bold;" class="text-start mb-5">Perusahaan yang terdaftar</h2>
    <!-- Carousel Start -->
    @php
        $chunks = $datapr->chunk(3); // 3 perusahaan per slide
    @endphp

    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            @foreach ($chunks as $index => $chunk)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="d-flex justify-content-center gap-4 px-3 py-4 flex-wrap">
                        @foreach ($chunk as $item)
                            <div class="card text-center shadow-sm border-0"
                                style="width: 18rem; border-radius: 20px; background-color: #ff69b4;">
                                <div class="card-body" style="padding: 20px;">
                                    <h5 class="card-title" style="color: #0d6efd; font-weight: bold;">
                                        {{ $item->nama }}</h5>
                                    <p class="card-text" style="color: white;">
                                        {{ $item->detailUser->alamat ?? 'Belum Dilengkapi' }}</p>
                                    <a href="/perusahaandetail/{{ $item->id }}" class="btn"
                                        style="background-color: #0d6efd; color: white; border: none; border-radius: 25px; padding: 8px 20px;">
                                        Lihat Profil
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigasi Panah -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-primary rounded-circle" aria-hidden="true"
                style="background-color: #0d6efd;"></span>
            <span class="visually-hidden">Sebelumnya</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon bg-primary rounded-circle" aria-hidden="true"
                style="background-color: #d63384;"></span>
            <span class="visually-hidden">Selanjutnya</span>
        </button>

        <!-- Indicators -->
        <div class="carousel-indicators mt-3">
            @foreach ($chunks as $index => $chunk)
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $index }}"
                    class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}"
                    style="width: 10px; height: 10px; border-radius: 50%; background-color: {{ $index === 0 ? '#0d6efd' : '#0d6efd' }};">
                </button>
            @endforeach
        </div>
    </div>
</div>
