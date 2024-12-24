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
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('age');
            $table->integer('height');
            $table->decimal('current_weight', 3, 2);
            $table->integer('goal_weight');
            $table->decimal('hips', 3, 2);
            $table->decimal('waist', 3, 2);
            $table->decimal('chest', 3, 2);
            $table->decimal('bmi', 3, 2)->nullable();
            $table->string('before_photo')->nullable();
            $table->string('after_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress');
    }
};
