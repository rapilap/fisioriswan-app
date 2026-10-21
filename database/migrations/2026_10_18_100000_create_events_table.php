<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Event hasil kolaborasi yang ditampilkan di bagian "Event mendatang".
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('event_date')->index();
            $table->string('start_time', 5);              // "09:00"
            $table->string('end_time', 5)->nullable();    // "12:00"
            $table->string('location');
            $table->text('description');
            $table->string('registration_url', 2048)->nullable(); // link tombol "Daftar Sekarang"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
