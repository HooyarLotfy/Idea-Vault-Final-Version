<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IdeaController extends Controller
{
    public function index(Request $request)
    {
        $query = Idea::query();

        // Advanced filtering with fallbacks for missing columns
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
                
                // Only search tag if column exists
                if (\Schema::hasColumn('ideas', 'tag')) {
                    $q->orWhere('tag', 'like', '%' . $searchTerm . '%');
                }
                // Only search category if column exists
                 if (\Schema::hasColumn('ideas', 'category')) {
                    $q->orWhere('category', 'like', '%' . $searchTerm . '%');
                }
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority') && \Schema::hasColumn('ideas', 'priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category') && \Schema::hasColumn('ideas', 'category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('favorites') && \Schema::hasColumn('ideas', 'is_favorite')) {
            $query->where('is_favorite', true);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $ideas = $query->paginate(12);

        // Dashboard stats with safe column checking
        $stats = [
            'total' => Idea::count(),
            'pending' => Idea::where('status', 'pending')->count(),
            'in_progress' => Idea::where('status', 'in_progress')->count(),
            'completed' => Idea::where('status', 'completed')->count(),
            'overdue' => 0,
            'upcoming' => 0,
            'favorites' => 0,
            'completion_rate' => 0
        ];

        // Only calculate these if columns exist
        if (\Schema::hasColumn('ideas', 'due_date')) {
            $stats['overdue'] = Idea::where('due_date', '<', now())
                ->where('status', '!=', 'completed')->count();
            $stats['upcoming'] = Idea::where('due_date', '>', now())
                ->where('due_date', '<=', now()->addDays(7))->count();
        }

        if (\Schema::hasColumn('ideas', 'is_favorite')) {
            $stats['favorites'] = Idea::where('is_favorite', true)->count();
        }

        $stats['completion_rate'] = $stats['total'] > 0 ? 
            ($stats['completed'] / $stats['total']) * 100 : 0;

        $categories = \Schema::hasColumn('ideas', 'category') ? 
            Idea::distinct('category')->pluck('category')->filter() : collect();

        return view('ideas.index', compact('ideas', 'stats', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'tag' => 'nullable|string|max:100',
            'status' => 'required|in:pending,in_progress,completed,on_hold',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'category' => 'nullable|string|max:100',
            'estimated_hours' => 'nullable|numeric|min:0',
            'due_date' => 'nullable|date|after:today',
            'color_theme' => 'nullable|string|max:50',
            'notes' => 'nullable|string'
        ]);

        $validated['completion_percentage'] = $validated['status'] === 'completed' ? 100 : 0;

        $idea = Idea::create($validated);

        Cache::forget('idea_stats');

        return response()->json([
            'success' => true,
            'message' => 'Idea created successfully!',
            'idea' => $idea->fresh()
        ]);
    }

    public function update(Request $request, Idea $idea)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'tag' => 'nullable|string|max:100',
            'status' => 'required|in:pending,in_progress,completed,on_hold',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'category' => 'nullable|string|max:100',
            'estimated_hours' => 'nullable|numeric|min:0',
            'completion_percentage' => 'nullable|integer|min:0|max:100',
            'due_date' => 'nullable|date',
            'color_theme' => 'nullable|string|max:50',
            'notes' => 'nullable|string'
        ]);

        // Auto-set completion percentage based on status
        if ($validated['status'] === 'completed' && !isset($validated['completion_percentage'])) {
            $validated['completion_percentage'] = 100;
        } elseif ($validated['status'] === 'pending' && !isset($validated['completion_percentage'])) {
            $validated['completion_percentage'] = 0;
        }

        $idea->update($validated);

        Cache::forget('idea_stats');

        return response()->json([
            'success' => true,
            'message' => 'Idea updated successfully!',
            'idea' => $idea->fresh()
        ]);
    }

    public function destroy(Idea $idea)
    {
        $idea->delete();
        Cache::forget('idea_stats');

        return response()->json([
            'success' => true,
            'message' => 'Idea deleted successfully!'
        ]);
    }

    public function toggleFavorite(Idea $idea)
    {
        $idea->update(['is_favorite' => !$idea->is_favorite]);

        return response()->json([
            'success' => true,
            'is_favorite' => $idea->is_favorite
        ]);
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,complete,archive,change_status,change_priority',
            'ids' => 'required|array',
            'ids.*' => 'exists:ideas,id',
            'value' => 'nullable|string'
        ]);

        $ideas = Idea::whereIn('id', $validated['ids']);

        switch ($validated['action']) {
            case 'delete':
                $ideas->delete();
                break;
            case 'complete':
                $ideas->update(['status' => 'completed', 'completion_percentage' => 100]);
                break;
            case 'change_status':
                $ideas->update(['status' => $validated['value']]);
                break;
            case 'change_priority':
                $ideas->update(['priority' => $validated['value']]);
                break;
        }

        Cache::forget('idea_stats');

        return response()->json([
            'success' => true,
            'message' => 'Bulk action completed successfully!'
        ]);
    }
}
