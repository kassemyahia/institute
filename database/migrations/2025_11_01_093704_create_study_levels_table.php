<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50); // مثل: تاسع، عاشر، حادي عشر...
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_levels');
    }
};
