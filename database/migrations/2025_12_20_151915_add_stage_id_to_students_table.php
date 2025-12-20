<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (! Schema::hasColumn('students', 'stage_id')) {
                $table->foreignId('stage_id')->nullable()->constrained('stages')->nullOnDelete()->after('section_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'stage_id')) {
                $table->dropConstrainedForeignId('stage_id');
            }
        });
    }
};
