<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\detail_users; // Menggunakan nama model Anda

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key check untuk proses truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        detail_users::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = \Faker\Factory::create('id_ID');

        // === MEMBUAT 7 PERUSAHAAN ===
        $companies = [
            ['nama' => 'PT Teknologi Maju Bersama', 'website' => 'https://techmaju.com', 'visi' => 'Menjadi pemimpin inovasi teknologi di Asia Tenggara.'],
            ['nama' => 'CV Pangan Sejahtera', 'website' => 'https://pangansejahtera.co.id', 'visi' => 'Menyediakan pangan berkualitas untuk seluruh lapisan masyarakat.'],
            ['nama' => 'Stark Industries Indonesia', 'website' => 'https://starkindustries.id', 'visi' => 'Membangun masa depan yang lebih baik melalui teknologi.'],
            ['nama' => 'Wayne Enterprises Cabang Jakarta', 'website' => 'https://wayne-ent-jkt.com', 'visi' => 'Meningkatkan kualitas hidup warga Jakarta.'],
            ['nama' => 'Cyberdyne Systems', 'website' => 'https://cyberdyne.net', 'visi' => 'Menciptakan jaringan pertahanan global yang terotomatisasi.'],
            ['nama' => 'Otsuka Pharmaceutical', 'website' => 'https://otsuka.co.id', 'visi' => 'Berkontribusi untuk kesehatan masyarakat dunia.'],
            ['nama' => 'Umbrella Corporation', 'website' => 'https://umbrella-corp.com', 'visi' => 'Menjadi yang terdepan dalam inovasi farmasi global.'],
        ];

        foreach ($companies as $company) {
            $user = User::create([
                'nama' => $company['nama'],
                'email' => strtolower(str_replace(' ', '', $company['nama'])) . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'perusahaan',
                'foto' => 'deflaut_user.png',
            ]);

            detail_users::create([
                'user_id' => $user->id,
                'alamat' => $faker->address,
                'noTlp' => $faker->phoneNumber,
                'visi' => $company['visi'],
                'misi' => 'Memberikan produk dan layanan terbaik dengan integritas dan profesionalisme tinggi.',
                'website' => $company['website'],
                'link_maps' => 'https://maps.google.com/?q=' . $faker->latitude . ',' . $faker->longitude,
                'deskripsi_pribadi' => 'Didirikan pada ' . $faker->year . ', ' . $user->nama . ' telah berkembang menjadi pemain utama di industrinya.',
            ]);
        }

        // === MEMBUAT 20 PELAMAR ===
        $pendidikan = ['SMA/SMK', 'D3', 'S1', 'S2'];
        for ($i = 0; $i < 20; $i++) {
            $gender = $faker->randomElement(['Laki-Laki', 'Perempuan']);
            $nama = $faker->name($gender == 'Laki-Laki' ? 'male' : 'female');

            $user = User::create([
                'nama' => $nama,
                'email' => strtolower(str_replace(' ', '.', $nama)) . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'pelamar',
                'foto' => 'deflaut_user.png',
            ]);

            detail_users::create([
                'user_id' => $user->id,
                'file_cv' => 'contoh_cv.pdf',
                'alamat' => $faker->address,
                'noTlp' => $faker->phoneNumber,
                'tanggal_lahir' => $faker->date('Y-m-d', '2002-01-01'),
                'tempat_lahir' => $faker->city,
                'jenis_kelamin' => $gender,
                'tingkat_pendidikan' => $faker->randomElement($pendidikan),
                'nama_instansi' => 'Universitas ' . $faker->city . ' ' . $faker->lastName,
                'tahun_lulus' => $faker->date('Y-m-d', '2023-12-31'),
                'nilai_akhir' => $faker->randomFloat(2, 3.00, 4.00),
                'deskripsi_pribadi' => 'Seorang yang bersemangat, pekerja keras, dan mudah beradaptasi. Memiliki motivasi tinggi untuk belajar dan berkembang.',
            ]);
        }
    }
}