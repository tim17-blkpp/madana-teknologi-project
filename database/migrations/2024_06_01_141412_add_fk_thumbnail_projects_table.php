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
        //
        Schema::table('projects', function (Blueprint $table) {
            // $table->foreignId('thumbnail_id')->nullable()->constrained('galleries')->onDelete('set null');
            $table->string('thumbnail_path')->nullable()->after('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('projects', function (Blueprint $table) {
            // $table->dropForeign(['thumbnail_id']);
            // $table->dropColumn('thumbnail_id');
            $table->dropColumn('thumbnail_path');
        });
    }
};
