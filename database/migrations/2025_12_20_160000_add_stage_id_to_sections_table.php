<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            if (! Schema::hasColumn('sections', 'stage_id')) {
                $table->foreignId('stage_id')->nullable()->constrained('stages')->nullOnDelete()->after('grade_level');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            if (Schema::hasColumn('sections', 'stage_id')) {
                $table->dropConstrainedForeignId('stage_id');
            }
        });
    }
};
