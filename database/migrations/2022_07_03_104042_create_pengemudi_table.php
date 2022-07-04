<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengemudiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengemudi', function (Blueprint $table) {
            $table->id();
            $table->text('nama')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('nomor_telepon', 15)->nullable();
            $table->text('foto')->nullable();
            $table->set('bahasa', ['Indonesia', 'Inggris'])->nullable();
            $table->text('sim')->nullable();
            $table->text('surat_bebas_napza')->nullable();
            $table->text('surat_kesehatan_jiwa')->nullable();
            $table->text('surat_kesehatan_jasmani')->nullable();
            $table->text('skck')->nullable();
            $table->boolean('tersedia')->default(0);
            $table->string('email', 320);
            $table->string('password', 255);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengemudi');
    }
}
