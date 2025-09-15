<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            // $table->text('deskripsi_singkat')->nullable();

            // Foreign Keys - sesuai pattern yang ada
            $table->unsignedBigInteger('id_kategori_event');
            $table->unsignedBigInteger('id_range_event');
            $table->unsignedBigInteger('id_created_by');

            // Event Details
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('batas_pendaftaran');
            $table->date('batas_submission')->nullable();
            // $table->time('jam_mulai')->nullable();
            // $table->time('jam_selesai')->nullable();

            // Location & Venue
            // $table->string('lokasi')->nullable();
            // $table->text('alamat_lengkap')->nullable();
            // $table->boolean('is_online')->default(false);
            // $table->string('platform_online')->nullable();
            // $table->text('link_event')->nullable();

            // Capacity & Pricing
            // $table->integer('max_peserta')->nullable();
            // $table->decimal('biaya_pendaftaran', 12, 2)->default(0);
            // $table->string('mata_uang', 3)->default('IDR');

            // Status & Visibility
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');
            // $table->boolean('is_featured')->default(false);
            // $table->boolean('is_public')->default(true);

            // Media
            $table->string('banner_image')->nullable();
            // $table->json('gallery_images')->nullable();

            // // SEO & Marketing
            // $table->string('meta_title')->nullable();
            // $table->text('meta_description')->nullable();
            // $table->json('tags')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_kategori_event')->references('id')->on('kategori_event')->onDelete('cascade');
            $table->foreign('id_range_event')->references('id')->on('range_event')->onDelete('cascade');
            $table->foreign('id_created_by')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            // $table->index(['status', 'is_public']);
            $table->index(['tanggal_mulai', 'tanggal_selesai']);
            $table->index(['id_kategori_event', 'id_range_event']);
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
