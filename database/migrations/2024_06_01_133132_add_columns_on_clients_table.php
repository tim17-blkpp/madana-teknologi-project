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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('address');
            $table->boolean('show_on_landing_page')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('logo');
            $table->dropColumn('show_on_landing_page');
        });
    }
};
