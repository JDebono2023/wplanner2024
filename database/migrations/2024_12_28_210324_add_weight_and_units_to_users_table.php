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
            $table->enum('unit_height', ['imperial', 'metric'])->nullable();
            $table->float('goal_weight')->nullable();
            $table->enum('unit_goal', ['imperial', 'metric'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['goal_weight', 'unit_height', 'unit_weight']);
        });
    }
};
