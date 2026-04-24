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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('umur')->nullable();
            $table->string('kelompok_umur')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('agama')->nullable();
            $table->string('status_pegawai')->nullable();
            $table->string('jenis_kantor')->nullable();
            $table->string('jenis_jabatan')->nullable();
            $table->string('kelompok_fungsional')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('nama_jabatan')->nullable();
            $table->string('jabatan_murni')->nullable();
            $table->string('unit_kerja_eselon_1')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('golongan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
