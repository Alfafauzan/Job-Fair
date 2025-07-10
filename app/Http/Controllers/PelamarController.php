<?php

namespace App\Http\Controllers;

use App\Models\lowongans;
use App\Models\pengalaman_kerjas;
use App\Services\LowonganService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PelamarController extends Controller
{
    protected $applyLowonganService;

    public function __construct(LowonganService $applyLowonganService)
    {
        $this->applyLowonganService = $applyLowonganService;
    }

    public function showAllLowongan(): RedirectResponse
    {
        try {
            $lowongans = lowongans::with('perusahaan')->get();
            session(['lowongans_all' => $lowongans]);
            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengambil daftar lowongan: ' . $e->getMessage()]);
        }
    }
    public function applyLowongan(Request $request)
    {
        
        return $this->applyLowonganService->applyLowongan($request->all());
    }

    public function AddPengalaman(Request $request)
    {
        foreach ($request->jobs as $job) {
            pengalaman_kerjas::create([
                'nama_perusahaan' => $job['nama_perusahaan'],
                'jabatan' => $job['jabatan'],
                "user_id" => Auth::user()->id,
                'deskripsi_pekerjaan' => $job['deskripsi_pekerjaan'],
                'skil' => $job['skil'],
                'tahun_masuk' => $job['tahun_masuk'],
                'tahun_keluar' => $job['tahun_keluar'],
                'tipe_pekerjaan' => $job['tipe_pekerjaan'],
            ]);
        }

        return redirect()->back()->with('success_pengalaman', 'Pengalaman kerja berhasil disimpan.');
    }
    public function EditPengalaman(Request $request, $id)
    {
        try {
            $pengalaman = pengalaman_kerjas::find($id);
            $pengalaman->nama_perusahaan = $request->nama_perusahaan ?? $pengalaman->nama_perusahaan;
            $pengalaman->jabatan = $request->jabatan ?? $pengalaman->jabatan;
            $pengalaman->user_id = Auth::user()->id;
            $pengalaman->deskripsi_pekerjaan = $request->deskripsi_pekerjaan ?? $pengalaman->deskripsi_pekerjaan;
            $pengalaman->skil = $request->skil ?? $pengalaman->skil;
            $pengalaman->tahun_masuk = $request->tahun_masuk ?? $pengalaman->tahun_masuk;
            $pengalaman->tahun_keluar = $request->tahun_keluar ?? $pengalaman->tahun_keluar;
            $pengalaman->tipe_pekerjaan = $request->tipe_pekerjaan ?? $pengalaman->tipe_pekerjaan;
            $pengalaman->save();
            return redirect()->back()->with('success_pengalaman', 'Pengalaman kerja berhasil diperbarui.');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function DeletePengalaman($id)
    {
        try {
            $pengalaman = pengalaman_kerjas::find($id);
            $pengalaman->delete();
            return redirect()->back()->with('success_pengalaman', 'Pengalaman kerja berhasil Dihapus.');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function profilePelamar()
    {
        // Panggil method untuk mendapatkan rekomendasi
        $recommendedJobs = $this->getSimpleRecommendations();

        // Kirim data yang sudah ada DAN data rekomendasi baru ke view
        return view('Profil.Pelamar.profilPelamar', [
            "pengalamans" => pengalaman_kerjas::where('user_id', Auth::user()->id)->get(),
            "lamaran" => $this->applyLowonganService->getApplyLowonganByPelamarId(),
            "recommendedJobs" => $recommendedJobs // <-- DATA BARU
        ]);
    }

    public function cari(Request $request)
    {
        $query = lowongans::query();

        if ($request->filled('judul')) {
            $query->where('judul_lowongan', 'like', '%' . $request->judul . '%');
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        $data = $query->with('perusahaan')->latest()->paginate(6);

        if ($request->ajax()) {
            $view = view('components.list-pekerjaan', compact('data'))->render();
            $pagination = $data->withQueryString()->links()->render();

            return response()->json([
                'view' => $view,
                'pagination' => $pagination,
            ]);
        }

        return view('lowongan.hasil-pencarian', compact('data'));
    }

    private function getSimpleRecommendations()
    {
        // 1. Ambil data user yang sedang login beserta relasi pengalaman kerjanya
        $user = Auth::user()->load('pengalamanKerja');
        $userSkills = [];

        // 2. Kumpulkan semua skill dari setiap pengalaman kerja
        foreach ($user->pengalamanKerja as $pengalaman) {
            // Kolom 'skil' Anda sepertinya string (misal: "PHP, Laravel, MySQL")
            // Kita pecah string tersebut menjadi array
            if (!empty($pengalaman->skil)) {
                $skillsFromPengalaman = explode(',', $pengalaman->skil);
                // Gabungkan ke array utama
                $userSkills = array_merge($userSkills, $skillsFromPengalaman);
            }
        }
        
        // Bersihkan skill: hapus spasi berlebih dan hilangkan duplikat
        $userSkills = array_unique(array_map('trim', $userSkills));
        
        if (empty($userSkills)) {
            return collect(); // Jika tidak ada skill, tidak ada rekomendasi
        }

        // 3. Ambil semua lowongan pekerjaan
        $jobs = lowongans::with('perusahaan')->where('status_lowongan', 'aktif')->get();
        $recommendationScores = [];

        // 4. Loop setiap lowongan untuk menghitung skor
        foreach ($jobs as $job) {
            $score = 0;
            // Gabungkan teks dari lowongan menjadi satu
            $jobText = strtolower(
                $job->judul_lowongan . ' ' .
                $job->deskripsi_lowongan . ' ' .
                $job->kualifikasi
            );

            // Cek setiap skill user di dalam teks lowongan
            foreach ($userSkills as $skill) {
                if (!empty($skill) && str_contains($jobText, strtolower($skill))) {
                    $score++;
                }
            }

            if ($score > 0) {
                $recommendationScores[$job->id] = $score;
            }
        }

        // 5. Urutkan berdasarkan skor tertinggi
        arsort($recommendationScores);
        $topJobIds = array_slice(array_keys($recommendationScores), 0, 5); // Ambil 5 teratas

        if (empty($topJobIds)) {
            return collect();
        }

        // 6. Ambil data lowongan dari DB sesuai urutan skor
        return lowongans::whereIn('id', $topJobIds)
                        ->with('perusahaan')
                        ->orderByRaw('FIELD(id, ' . implode(',', $topJobIds) . ')')
                        ->get();
    }
}
