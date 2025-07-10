<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengalaman_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_perusahaan', 100);
            $table->string('jabatan', 100);
            $table->string('deskripsi_pekerjaan', 225);
            $table->string('skil', 225);
            $table->date('tahun_masuk');
            $table->date('tahun_keluar');
            $table->enum('tipe_pekerjaan', ['Freelance', 'Full-Time', 'Intern']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengalaman_kerjas');
    }
};