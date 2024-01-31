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
        Schema::create('cabinets_dbus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabinet_id')->nullable()->constrained('cabinets')->onDelete('set null');
            $table->foreignId('dbu_id')->nullable()->constrained('dbus')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabinets_dbus');
    }
};
