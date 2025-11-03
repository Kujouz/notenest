<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            // Add folder_id column first
            if (!Schema::hasColumn('notes', 'folder_id')) {
                $table->foreignId('folder_id')->constrained()->cascadeOnDelete()->after('user_id');
            }

            // Add missing file columns
            if (!Schema::hasColumn('notes', 'file_name')) {
                $table->string('file_name')->after('file_path');
            }

            if (!Schema::hasColumn('notes', 'file_type')) {
                $table->string('file_type')->after('file_name');
            }

            if (!Schema::hasColumn('notes', 'file_size')) {
                $table->unsignedBigInteger('file_size')->after('file_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn(['folder_id', 'file_name', 'file_type', 'file_size']);
        });
    }
};
