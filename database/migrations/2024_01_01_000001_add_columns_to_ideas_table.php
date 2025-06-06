how t<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add columns using raw SQL to avoid conflicts
        $columns = [
            'priority' => "ALTER TABLE ideas ADD COLUMN priority TEXT DEFAULT 'medium'",
            'category' => "ALTER TABLE ideas ADD COLUMN category TEXT",
            'estimated_hours' => "ALTER TABLE ideas ADD COLUMN estimated_hours DECIMAL(8,2)",
            'completion_percentage' => "ALTER TABLE ideas ADD COLUMN completion_percentage INTEGER DEFAULT 0",
            'is_favorite' => "ALTER TABLE ideas ADD COLUMN is_favorite BOOLEAN DEFAULT 0",
            'color_theme' => "ALTER TABLE ideas ADD COLUMN color_theme TEXT",
            'due_date' => "ALTER TABLE ideas ADD COLUMN due_date DATETIME",
            'notes' => "ALTER TABLE ideas ADD COLUMN notes TEXT",
            'deleted_at' => "ALTER TABLE ideas ADD COLUMN deleted_at TIMESTAMP"
        ];

        foreach ($columns as $columnName => $sql) {
            if (!Schema::hasColumn('ideas', $columnName)) {
                try {
                    DB::statement($sql);
                } catch (\Exception $e) {
                    // Column might already exist, continue
                }
            }
        }
    }

    public function down(): void
    {
        $columns = ['priority', 'category', 'estimated_hours', 'completion_percentage', 'is_favorite', 'color_theme', 'due_date', 'notes', 'deleted_at'];
        
        foreach ($columns as $column) {
            if (Schema::hasColumn('ideas', $column)) {
                try {
                    DB::statement("ALTER TABLE ideas DROP COLUMN {$column}");
                } catch (\Exception $e) {
                    // Continue if column doesn't exist
                }
            }
        }
    }
};
