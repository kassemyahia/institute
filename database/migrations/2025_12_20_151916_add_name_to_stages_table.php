<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            if (! Schema::hasColumn('stages', 'name')) {
                $table->string('name', 100)->unique()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            if (Schema::hasColumn('stages', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
