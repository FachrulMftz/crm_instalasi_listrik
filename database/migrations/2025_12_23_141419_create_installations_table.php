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
        Schema::create('installations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opportunity_id')->constrained()->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('scheduled_start');
            $table->dateTime('scheduled_end')->nullable();
            $table->string('status')->default('scheduled'); // contoh: scheduled, in_progress, completed, cancelled
            $table->integer('progress')->default(0); // 0-100
            $table->json('photos')->nullable(); // menyimpan array URL foto
            $table->json('checklist')->nullable(); // menyimpan array checklist (item => completed)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installations');
    }
};