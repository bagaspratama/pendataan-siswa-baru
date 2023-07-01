<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik',
        'nisn',
        'nama_lengkap',
        'jk',
        'tempat_lahir',
        'tgl_lahir',
        'agama',
        'anak_ke',
        'provinsi',
        'kab_kota',
        'kecamatan',
        'alamat_lengkap',
        'tinggal_bersama',
        'moda_transpotasi',
        'tb',
        'bb',
        'lk',
        'jarak_rumah',
        'waktu_tempuh',
        'jumlah_saudara',
        'nama_ibu',
        'nik_ibu',
        'tahun_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'nama_ayah',
        'nik_ayah',
        'tahun_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'asal_sekolah',
        'no_wa_wali',
        'kps_pkh',
        'kip',
        'url_pkh',
        'url_kip',
        'url_kk',
        'url_ijazah',
        'jurusan',
        'operator'
    ];
}
