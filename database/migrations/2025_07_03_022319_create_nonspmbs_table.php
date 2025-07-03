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
        Schema::create('nonspmbs', function (Blueprint $table) {
            $table->id();
              $table->string('nik', 17);
            $table->string('nisn', 17);
            $table->string('nama_lengkap');
            $table->string('jk', 2);
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->string('agama');
            $table->integer('anak_ke');
            $table->string('provinsi');
            $table->string('kab_kota');
            $table->string('kecamatan');
            $table->string('alamat_lengkap');
            $table->string('tinggal_bersama');
            $table->string('moda_transpotasi');
            $table->integer('tb')->nullable();
            $table->integer('bb')->nullable();
            $table->integer('lk')->nullable();
            $table->integer('jarak_rumah')->nullable();
            $table->integer('waktu_tempuh')->nullable();
            $table->integer('jumlah_saudara')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu', 17)->nullable();
            $table->string('tahun_ibu', 4)->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah', 17)->nullable();
            $table->string('tahun_ayah', 4)->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('tahun_lulus')->nullable();
            $table->string('no_wa_wali')->nullable();
            $table->string('kip')->nullable();
            $table->string('nomor_kartu')->nullable();
            $table->string('nama_kartu')->nullable();
            $table->string('url_kip')->nullable()->default(null);
            $table->string('url_kk')->nullable()->default(null);
            $table->string('jurusan')->nullable()->default(null);
            $table->string('operator');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nonspmbs');
    }
};
