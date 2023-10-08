<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id(); // Kolom ID yang otomatis
            $table->string('nama_lengkap'); // Kolom nama
            $table->string('nickname'); // Kolom nama
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->string('angkatan'); // Kolom nama
            $table->string('posisi'); // Kolom posisi
            $table->string('jabatan'); // Kolom jabatan
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->date('tanggal_lahir');
            $table->enum('motor', ['yes', 'no']);
            $table->timestamps(); // Kolom tanggal pembuatan dan pembaruan

            // Indeks untuk foreign key
            $table->foreign('jurusan_id')->references('id')->on('jurusans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggotas');
    }
}
