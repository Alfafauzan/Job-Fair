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
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul_lowongan');
            $table->text('deskripsi_lowongan');
            $table->text('kualifikasi')->nullable();
            $table->integer('gaji_minimum')->nullable();
            $table->integer('gaji_maximum')->nullable();
            $table->string('lokasi', 150)->nullable();
            $table->enum('tipe_pekerjaan', ['fulltime', 'parttime', 'remote', 'freelance']);
            $table->json('kategori_lowongan');
            $table->enum('status_lowongan', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};