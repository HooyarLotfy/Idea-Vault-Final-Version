<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('tag')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'on_hold'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->string('category')->nullable();
            $table->decimal('estimated_hours', 8, 2)->nullable();
            $table->integer('completion_percentage')->default(0);
            $table->boolean('is_favorite')->default(false);
            $table->string('color_theme')->nullable();
            $table->datetime('due_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes(); // This adds the deleted_at column

            $table->index(['status', 'priority']);
            $table->index(['category', 'status']);
            $table->index('due_date');
            $table->index('is_favorite');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};
