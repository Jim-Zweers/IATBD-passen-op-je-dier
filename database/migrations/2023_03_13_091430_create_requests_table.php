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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->date('from');
            $table->date('till');
            $table->float('hourly_rate');
            $table->boolean('status')->nullable()->comment('Null: In progress, False: Aborted, True: Completed');
            $table->unsignedBigInteger('pet_id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('sitter_id')->nullable();
            $table->timestamps();

            $table->foreign('pet_id')->references('id')->on('pets')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('owner_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('sitter_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
