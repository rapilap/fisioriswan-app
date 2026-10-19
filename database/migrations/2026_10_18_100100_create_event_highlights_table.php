<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Dokumentasi event sebelumnya untuk bagian "Sorotan event sebelumnya".
     */
    public function up(): void
    {
        Schema::create('event_highlights', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('image'); // path di disk "public", mis. sorotan/abc.jpg
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_highlights');
    }
};
