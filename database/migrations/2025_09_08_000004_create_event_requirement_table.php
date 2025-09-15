<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requirement', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->text('deskripsi');
            $table->timestamps();

            $table->foreign('event_id')
                ->references('id')
                ->on('event')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requirement');
    }
};
