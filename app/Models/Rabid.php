<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rabid extends Model
{
    use HasFactory;
    protected $table = 'rabids';

    protected $fillable = [
        'nama', 'tempat','waktu_mulai', 'waktu_selesai', 'tanggal','jumlah_anggota','catatan'
    ];

    public function pencatatanKehadiran()
    {
        return $this->hasMany(PencatatanKehadiran::class, 'rabid_id');
    }

}
