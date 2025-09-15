<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_event');
            $table->string('nama_sesi');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('pembicara')->nullable();
            $table->string('lokasi_sesi')->nullable();
            $table->integer('urutan')->default(1);
            $table->timestamps();

            $table->foreign('id_event')->references('id')->on('event')->onDelete('cascade');
            $table->index(['id_event', 'tanggal', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_schedules');
    }
};
