<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->enum('jenis_peserta', ['kampus', 'umum'])->default('kampus'); // kategori peserta
            $table->string('nim')->nullable(); // untuk peserta kampus
            $table->string('asal')->nullable(); // asal institusi/universitas
            $table->string('email')->unique();
            $table->string('password')->nullable(); // password untuk login peserta
            $table->string('no_telepon')->nullable(); // dari update migration
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable(); // dari update migration
            $table->text('alamat')->nullable(); // dari update migration
            $table->unsignedBigInteger('roles_id');
            $table->enum('status_pendaftaran', ['pending', 'approved', 'rejected'])->default('pending'); // dari update migration
            $table->timestamp('tanggal_daftar')->useCurrent(); // dari update migration
            $table->timestamps();

            $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');


            // Index untuk performance
            $table->index(['email', 'status_pendaftaran']);
            $table->index(['jenis_peserta', 'status_pendaftaran']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
