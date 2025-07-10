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
        Schema::create('detail_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('file_cv')->nullable();
            $table->string('alamat', 150)->nullable();
            $table->string('noTlp', 20)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir', 150)->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('website', 225)->nullable();
            $table->text('link_maps')->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->string('tingkat_pendidikan')->nullable();
            $table->string('nama_instansi')->nullable();
            $table->date('tahun_lulus')->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->text('deskripsi_pribadi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_users');
    }
};