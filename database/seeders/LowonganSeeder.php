<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\lowongans;

class LowonganSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key untuk truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        lowongans::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = \Faker\Factory::create('id_ID');
        $perusahaanUsers = User::where('role', 'perusahaan')->get();

        $posisi = ['Backend Developer', 'Frontend Developer', 'Data Scientist', 'UI/UX Designer', 'Digital Marketing Specialist', 'IT Support', 'Laravel Developer', 'React.js Fullstack', 'Akuntan Project Management'];
        $kategori = ['UI/UX', 'Frontend', 'Backend', 'Fullstack', 'Management'];
        $tipePekerjaan = ['fulltime', 'parttime', 'remote', 'freelance'];

        foreach ($perusahaanUsers as $perusahaan) {
            for ($i = 0; $i < 3; $i++) {
                lowongans::create([
                    'user_id' => $perusahaan->id,
                    'judul_lowongan' => $faker->randomElement($posisi),
                    'deskripsi_lowongan' => 'Kami mencari kandidat yang bersemangat untuk bergabung dengan tim kami yang dinamis.',
                    'kualifikasi' => "• Minimal S1 di bidang terkait.\n• Pengalaman minimal 2 tahun.\n• Mampu bekerja dalam tim dan mandiri.",
                    'gaji_minimum' => rand(5, 8) * 1000000,
                    'gaji_maximum' => rand(9, 15) * 1000000,
                    'lokasi' => $faker->city,
                    'tipe_pekerjaan' => $faker->randomElement($tipePekerjaan),
                    'kategori_lowongan' => $faker->randomElements($kategori, rand(1, 2)), // ✅ langsung array, tanpa json_encode
                    'status_lowongan' => 'aktif',
                ]);
            }
        }
    }
}
