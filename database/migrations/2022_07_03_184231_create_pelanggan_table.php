<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelangganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->string('id', 22)->primary();
            $table->text('nama')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('nomor_telepon', 15)->nullable();
            $table->text('foto')->nullable();
            $table->text('sim')->nullable();
            $table->text('kartu_identitas')->nullable();
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
        Schema::dropIfExists('pelanggan');
    }
}
