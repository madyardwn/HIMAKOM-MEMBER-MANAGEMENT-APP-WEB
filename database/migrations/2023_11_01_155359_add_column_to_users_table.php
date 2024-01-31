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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('dbu_id')->nullable()->constrained('dbus')->onDelete('set null');
            $table->foreignId('cabinet_id')->nullable()->constrained('cabinets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['dbu_id']);
            $table->dropForeign(['cabinet_id']);
            $table->dropColumn(['dbu_id', 'cabinet_id']);
        });
    }
};
