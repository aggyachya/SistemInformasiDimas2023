<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = 'jurusans';

    protected $fillable = [
        'nama_jurusan',
        'jumlah',
    ];

    public function anggotas()
    {
        return $this->hasMany(Anggota::class,'jurusan_id');
    }
}
