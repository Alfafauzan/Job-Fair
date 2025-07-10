<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\pengalaman_kerjas; // Menggunakan nama model Anda

class PengalamanKerjaSeeder extends Seeder
{
    public function run(): void
    {
        pengalaman_kerjas::truncate();
        $faker = \Faker\Factory::create('id_ID');
        $pelamarUsers = User::where('role', 'pelamar')->get();

        $jabatan = ['Staff IT', 'Marketing Digital', 'Analis Data', 'Web Developer', 'Project Manager', 'Graphic Designer', 'Akuntan'];
        $tipe = ['Freelance', 'Full-Time', 'Intern'];
        $skills = ['Project Management', 'Data Analysis', 'PHP', 'Laravel', 'React.js', 'Graphic Design', 'SEO', 'Public Speaking'];

        foreach ($pelamarUsers as $pelamar) {
            $jumlahPengalaman = rand(1, 3);

            for ($i = 0; $i < $jumlahPengalaman; $i++) {
                $tahunMasuk = $faker->dateTimeBetween('-5 years', '-2 years');
                $tahunKeluar = $faker->dateTimeBetween($tahunMasuk, '-1 years');

                pengalaman_kerjas::create([
                    'user_id' => $pelamar->id,
                    'nama_perusahaan' => $faker->company,
                    'jabatan' => $faker->randomElement($jabatan),
                    'deskripsi_pekerjaan' => 'Bertanggung jawab untuk ' . $faker->sentence(10) . ' dan berkolaborasi dengan tim untuk mencapai target.',
                    // PENTING: Simpan skill sebagai string JSON
                    'skil' => json_encode($faker->randomElements($skills, rand(2, 4))),
                    'tahun_masuk' => $tahunMasuk->format('Y-m-d'),
                    'tahun_keluar' => $tahunKeluar->format('Y-m-d'),
                    'tipe_pekerjaan' => $faker->randomElement($tipe),
                ]);
            }
        }
    }
}