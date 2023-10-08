<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas'; // Nama tabel dalam basis data

    protected $fillable = [
    'nama_lengkap',
    'nickname',  
    'jurusan_id', 
    'angkatan', 
    'posisi', 
    'jabatan', 
    'jenis_kelamin', 
    'tanggal_lahir', 
    'motor']; // Kolom yang dapat diisi

    

    public function pencatatanKehadiran()
    {
        return $this->hasMany(PencatatanKehadiran::class, 'anggota_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
