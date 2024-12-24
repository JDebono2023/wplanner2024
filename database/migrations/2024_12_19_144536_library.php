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
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('source_id')->references('id')->on('sources')->onDelete('cascade');
            $table->foreignId('type_m')->references('id')->on('type_mains')->onDelete('cascade');
            $table->foreignId('type_s')->references('id')->on('type_seconds')->onDelete('cascade')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
