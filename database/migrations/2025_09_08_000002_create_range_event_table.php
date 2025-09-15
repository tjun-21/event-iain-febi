<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('range_event', function (Blueprint $table) {
            $table->id();
            $table->string('nama_range');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('range_event');
    }
};
