<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('opportunity_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // PENTING: STRING / ENUM
            $table->enum('type', [
                'call',
                'meeting',
                'email',
                'visit',
                'follow_up',
                'other'
            ]);

            $table->string('subject');
            $table->text('description')->nullable();
            $table->dateTime('activity_date');

            $table->enum('status', [
                'planned',
                'completed',
                'cancelled'
            ])->default('planned');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};