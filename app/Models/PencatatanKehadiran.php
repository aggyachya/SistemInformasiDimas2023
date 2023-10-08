<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencatatanKehadiran extends Model
{
    use HasFactory;
    protected $table = 'pencatatan_kehadirans'; // Nama tabel sesuai dengan tabel di database
    protected $fillable = [
        'anggota_id', 
        'rabid_id', 
        'status', 
        'waktu_kehadiran', 
        'keterangan', 
        'catatan'
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class,'anggota_id');
    }

    public function rabid()
    {
        return $this->belongsTo(Rabid::class, 'rabid_id');
    }
}
