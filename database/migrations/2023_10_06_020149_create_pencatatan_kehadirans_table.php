<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePencatatanKehadiransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pencatatan_kehadirans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anggota_id');
            $table->unsignedBigInteger('rabid_id');
            $table->enum('status', ['hadir', 'izin', 'tidak hadir']);
            $table->timestamp('waktu_kehadiran')->nullable();
            $table->string('keterangan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Indeks untuk foreign key
            $table->foreign('anggota_id')->references('id')->on('anggotas');
            $table->foreign('rabid_id')->references('id')->on('rabids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pencatatan_kehadirans');
    }
}
