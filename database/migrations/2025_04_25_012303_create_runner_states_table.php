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
        Schema::create('runner_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('runner_id')->constrained('runners')->onDelete('cascade');
            $table->foreignId('message_id')->constrained('messages')->onDelete('cascade')->nullable();
            $table->varchar('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('runner_states');
    }
};
