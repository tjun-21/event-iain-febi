<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_peserta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_event');
            $table->unsignedBigInteger('id_peserta');
            $table->enum('status', ['registered', 'confirmed', 'attended', 'completed', 'cancelled'])->default('registered');
            $table->timestamp('tanggal_daftar')->useCurrent();
            $table->timestamp('tanggal_konfirmasi')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->decimal('biaya_dibayar', 12, 2)->default(0);
            $table->enum('status_pembayaran', ['pending', 'paid', 'refunded'])->default('pending');
            $table->timestamps();
            
            $table->foreign('id_event')->references('id')->on('event')->onDelete('cascade');
            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            
            // Prevent duplicate registration
            $table->unique(['id_event', 'id_peserta']);
            $table->index(['id_event', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_peserta');
    }
};
