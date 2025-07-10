# 🎓 Job Fair Website

Website **Job Fair** berbasis **Laravel 12**, menggunakan **Blade Templating** dan **MySQL (Laragon)** sebagai database.  
Proyek ini dirancang sebagai platform rekrutmen **antara pelamar kerja dan perusahaan**, tanpa peran admin.

---

> [!NOTE]
> ## 💻 Pengembang
> ### Nama: Muhammad Alfa Fauzan
> ### Posisi: Fullstack Developer & Laravel (Internship)
> ### Program: Magang Kampus Merdeka – PT. Winnicode Garuda Teknologi

## 🧩 Alur Sistem

### 👤 Pelamar
- Membuat akun & login
- Mengisi profil & skill
- Melamar ke lowongan yang tersedia
- Melihat status lamaran: ✅ diterima / ❌ ditolak
- Menerima **rekomendasi lowongan** berdasarkan skill

### 🏢 Perusahaan
- Registrasi & login
- Membuat dan mengelola lowongan kerja
- Melihat lamaran masuk
- Memberi notifikasi: **diterima** atau **ditolak**
- Menghubungi pelamar jika cocok (WA / Email / Kontak)

---

## 🚀 Tech Stack

| Teknologi   | Fungsi                       |
|-------------|------------------------------|
| Laravel 12  | Framework backend            |
| Blade       | Template engine Laravel      |
| MySQL       | Database (via Laragon)       |
| Bootstrap   | Frontend styling             |
| Git & GitHub| Version control              |

---

## 📦 Installation

> ⚠️ **Pastikan** telah menginstall **Laragon**, **Composer**, dan **Git** terlebih dahulu.

### 🔁 1. Clone Project

```bash
git clone https://github.com/Alfafauzan/Job-Fair.git
cd Job-Fair
```

### 🧼 2. Hapus storage dan cache (jika ada sisa build lama)

```bash
php artisan storage:clear
php artisan config:clear
php artisan cache:clear
```

### 📦 3. Install dependency

```bash
composer install
```

### 🔑 4. Copy file environment dan generate key

```bash
cp .env.example .env
php artisan key:generate
```

### 🛠️ 5. Konfigurasi database .env

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobfair
DB_USERNAME=root
DB_PASSWORD=
```
### 🧬 6. Buat database baru di phpMyAdmin (Laragon)
Nama database: jobfair

### 🛢️ 7. Jalankan migrasi dan seeder (opsional)

```bash
php artisan migrate
php artisan db:seed
```

### 🌐 8. Jalankan server Laravel

```bash
php artisan serve
```

## 👤 Roles dalam Sistem
### Pelamar:
+ Registrasi dan login
+ Membuat dan melengkapi profil (termasuk skill)
+ Melamar ke lowongan kerja
+ Melihat status lamaran: diterima / ditolak
+ Menerima rekomendasi lowongan berdasarkan skill

### Perusahaan:
- Registrasi dan login
- Membuat dan mengelola lowongan kerja
- Melihat daftar pelamar yang melamar
- Mengirim notifikasi diterima / ditolak
- Menghubungi pelamar jika cocok

## 🖼️ Preview Website 
### 🏠 Landing Page:
<img width="1883" height="943" alt="Image" src="https://github.com/user-attachments/assets/e4322b0c-384b-4ee5-8486-da337741150d" />


🔐 Login Page:
<img width="1901" height="946" alt="Image" src="https://github.com/user-attachments/assets/49fdee9c-3a2f-4c9c-870d-b84e2510b7ff" />

💼 Daftar Lowongan:
<img width="910" height="949" alt="Image" src="https://github.com/user-attachments/assets/184c7b4f-3343-44b7-8f92-9c478af695b2" />

📄 Detail Lowongan:
<img width="1516" height="943" alt="Image" src="https://github.com/user-attachments/assets/ff02ceb8-0bf5-42b8-a514-be46808af095" />

🧠 Rekomendasi Skill:
<img width="994" height="941" alt="Image" src="https://github.com/user-attachments/assets/39e8ec39-96ff-4be2-9e29-0af894756f79" />





