<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('file', function (Blueprint $table) {
            $table->id();
            $table->string('original_name'); // nama file asli
            $table->string('file_path'); // path file
            $table->unsignedBigInteger('id_event_peserta');
            $table->string('file_category')->default('submission'); // kategori file
            $table->text('description')->nullable(); // deskripsi file
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // status validasi
            $table->timestamps();

            $table->foreign('id_event_peserta')->references('id')->on('event_peserta')->onUpdate('cascade')->onDelete('cascade');

            // Index untuk performance
            $table->index(['id_event_peserta', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file');
    }
};
