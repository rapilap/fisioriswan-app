
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('fullname');
            $table->string('city');
            $table->string('image')->nullable();
            $table->text('testimonial');
            $table->string('status')->default('pending');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn([
                'fullname',
                'city',
                'image',
                'testimonial',
                'status',
            ]);
        });
    }
};
