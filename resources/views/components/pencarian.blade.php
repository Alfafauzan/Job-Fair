<form id="formCariLowongan" class="mb-4">
    <div class="container py-4 px-3" style="background-color: white; border-radius: 15px;">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="position-relative">
                    <i class="fas fa-search position-absolute ps-2"
                        style="top: 50%; left: 12px; transform: translateY(-50%); color: #d63384;"></i>
                    <input type="text" name="judul" placeholder="Cari posisi atau pekerjaan..."
                        class="form-control ps-5" style="border: 2px solid #d63384; border-radius: 10px;">
                </div>
            </div>

            <div class="col-md-4">
                <input type="text" name="lokasi" placeholder="Masukkan lokasi" class="form-control"
                    style="border: 2px solid #0d6efd; border-radius: 10px;">
            </div>

            <div class="col-md-3 d-grid">
                <button type="submit" class="btn"
                    style="background-color: #0d6efd; color: white; border-radius: 10px; font-weight: bold;">
                    Cari
                </button>
            </div>
        </div>
    </div>
</form>

<div class="container">
    <h4 id="judulHasil" class="text-center mt-4 mb-3" style="color: #d63384; display: none;">Hasil Pencarian</h4>

    <div id="hasil-lowongan" class="row row-cols-1 row-cols-md-2 g-4 mt-2">
        {{-- AJAX data muncul di sini --}}
    </div>

    <div id="pagination-wrapper" class="mt-4 text-center">
        {{-- Pagination muncul di sini --}}
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formCariLowongan');
        const hasilContainer = document.getElementById('hasil-lowongan');
        const paginationWrapper = document.getElementById('pagination-wrapper');
        const inputs = form.querySelectorAll('input');
        let debounceTimer;

        function fetchData(url = null) {
            const formData = new FormData(form);
            const judul = formData.get('judul')?.trim();
            const lokasi = formData.get('lokasi')?.trim();
            const heading = document.getElementById('judulHasil');

            // ✅ Jika input kosong, kosongkan semua & sembunyikan heading
            if (!judul && !lokasi) {
                hasilContainer.innerHTML = '';
                paginationWrapper.innerHTML = '';
                heading.style.display = 'none';
                return;
            }

            const query = new URLSearchParams(formData).toString();
            const endpoint = url ?? `{{ route('lowongan.cari') }}?${query}`;

            fetch(endpoint, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    hasilContainer.innerHTML = data.view;
                    paginationWrapper.innerHTML = data.pagination;
                    if (data.view && data.view.trim() !== '') {
                        heading.style.display = 'block';
                    } else {
                        heading.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Gagal fetch data:', error);
                });
        }



        form.addEventListener('submit', function(e) {
            e.preventDefault();
            fetchData();
        });

        inputs.forEach(input => {
            input.addEventListener('keyup', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => fetchData(), 400); // debounce
            });
        });

        paginationWrapper.addEventListener('click', function(e) {
            if (e.target.tagName === 'A') {
                e.preventDefault();
                const url = e.target.getAttribute('href');
                if (url) fetchData(url);
            }
        });

        fetchData(); // load awal
    });
</script>
