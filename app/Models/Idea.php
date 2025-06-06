<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Idea extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'tag',
        'status',
        'priority',
        'category',
        'estimated_hours',
        'completion_percentage',
        'is_favorite',
        'color_theme',
        'due_date',
        'notes'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'is_favorite' => 'boolean',
        'completion_percentage' => 'integer',
        'estimated_hours' => 'decimal:2'
    ];

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeFavorites($query)
    {
        return $query->where('is_favorite', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())->where('status', '!=', 'completed');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('due_date', '>', now())->where('due_date', '<=', now()->addDays(7));
    }

    // Accessors
    public function getIsOverdueAttribute()
    {
        return $this->due_date && $this->due_date < now() && $this->status !== 'completed';
    }

    public function getTimeUntilDueAttribute()
    {
        if (!$this->due_date) return null;
        return $this->due_date->diffForHumans();
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'from-yellow-400 to-orange-500',
            'in_progress' => 'from-blue-400 to-purple-500',
            'completed' => 'from-green-400 to-emerald-500',
            'on_hold' => 'from-gray-400 to-gray-600',
            default => 'from-gray-400 to-gray-600'
        };
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'from-green-400 to-green-600',
            'medium' => 'from-yellow-400 to-yellow-600',
            'high' => 'from-orange-400 to-red-500',
            'urgent' => 'from-red-500 to-pink-600',
            default => 'from-gray-400 to-gray-600'
        };
    }
}
