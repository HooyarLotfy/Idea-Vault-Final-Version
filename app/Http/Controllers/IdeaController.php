<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class IdeaController extends Controller
{
    /**
     * Display a listing of the ideas.
     */
    public function index(Request $request)
    {
        // Redirect to filter method which handles both regular and AJAX requests
        return $this->filter($request);
    }

    /**
     * Store a newly created idea in storage.
     */
    public function store(Request $request)
    {
        Log::info('Store idea request received', ['data' => $request->all()]);
        
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|in:pending,in_progress,completed,on_hold',
                'priority' => 'nullable|in:low,medium,high,urgent',
                'tag' => 'nullable|string|max:50',
                'category' => 'nullable|string|max:50',
                'estimated_hours' => 'nullable|numeric',
                'due_date' => 'nullable|date',
                'notes' => 'nullable|string',
            ]);
            
            if ($validator->fails()) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                }
                
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $idea = Idea::create($validator->validated());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Idea created successfully!',
                    'idea' => $idea
                ]);
            }
            
            return redirect()->route('ideas.index')
                ->with('success', 'Idea created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating idea', ['error' => $e->getMessage()]);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating idea: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Error creating idea: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the specified idea in storage.
     */
    public function update(Request $request, Idea $idea)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|in:pending,in_progress,completed,on_hold',
                'priority' => 'nullable|in:low,medium,high,urgent',
                'tag' => 'nullable|string|max:50',
                'category' => 'nullable|string|max:50',
                'estimated_hours' => 'nullable|numeric',
                'completion_percentage' => 'nullable|integer|min:0|max:100',
                'due_date' => 'nullable|date',
                'notes' => 'nullable|string',
            ]);
            
            if ($validator->fails()) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                }
                
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $idea->update($validator->validated());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Idea updated successfully!',
                    'idea' => $idea
                ]);
            }
            
            return redirect()->route('ideas.index')
                ->with('success', 'Idea updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating idea', ['error' => $e->getMessage()]);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating idea: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Error updating idea: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified idea from storage.
     */
    public function destroy(Request $request, Idea $idea)
    {
        try {
            $idea->delete();
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Idea deleted successfully!'
                ]);
            }
            
            return redirect()->route('ideas.index')
                ->with('success', 'Idea deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting idea', ['error' => $e->getMessage()]);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting idea: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Error deleting idea: ' . $e->getMessage());
        }
    }

    /**
     * Toggle favorite status of an idea.
     */
    public function toggleFavorite(Request $request, Idea $idea)
    {
        try {
            $idea->is_favorite = !$idea->is_favorite;
            $idea->save();
            
            return response()->json([
                'success' => true,
                'is_favorite' => $idea->is_favorite,
                'message' => $idea->is_favorite ? 'Added to favorites' : 'Removed from favorites'
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling favorite status', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating favorite status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Filter ideas based on request parameters.
     */
    public function filter(Request $request)
    {
        try {
            Log::info('Filter request received', [
                'parameters' => $request->all(),
                'is_ajax' => $request->ajax()
            ]);
            
            $query = Idea::query();

            // Apply search filter
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%');
                    
                    // Add other searchable columns if they exist in the schema
                    $columns = ['tag', 'category', 'notes'];
                    foreach ($columns as $column) {
                        if (Schema::hasColumn('ideas', $column)) {
                            $q->orWhere($column, 'like', '%' . $searchTerm . '%');
                        }
                    }
                });
            }

            // Apply status filter
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Apply priority filter
            if ($request->filled('priority') && Schema::hasColumn('ideas', 'priority')) {
                $query->where('priority', $request->priority);
            }

            // Apply category filter
            if ($request->filled('category') && Schema::hasColumn('ideas', 'category')) {
                $query->where('category', $request->category);
            }

            // Apply favorites filter
            if ($request->filled('favorites') && $request->favorites === 'true' && Schema::hasColumn('ideas', 'is_favorite')) {
                $query->where('is_favorite', true);
            }

            // Apply sorting
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            
            if (Schema::hasColumn('ideas', $sortBy)) {
                $query->orderBy($sortBy, $sortOrder);
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $ideas = $query->paginate(12)->withQueryString();
            
            // Get distinct categories for filters
            $categories = Idea::whereNotNull('category')
                ->distinct()
                ->pluck('category');

            // Calculate stats for dashboard
            $stats = [
                'total' => Idea::count(),
                'pending' => Idea::where('status', 'pending')->count(),
                'in_progress' => Idea::where('status', 'in_progress')->count(),
                'completed' => Idea::where('status', 'completed')->count(),
                'overdue' => Idea::whereNotNull('due_date')->where('due_date', '<', now())->where('status', '!=', 'completed')->count(),
                'upcoming' => Idea::whereNotNull('due_date')->where('due_date', '>', now())->count(),
                'favorites' => Idea::where('is_favorite', true)->count(),
            ];

            // Handle AJAX requests for content refresh
            if ($request->ajax() || $request->wantsJson()) {
                Log::info('Responding to AJAX request');
                
                $viewMode = $request->get('view_mode', 'grid');
                
                // Add eager loading to ensure all related data is available
                $ideas->each(function($idea) {
                    // Make sure dates are properly formatted
                    if ($idea->due_date) {
                        $idea->due_date = $idea->due_date->toDateTimeString();
                    }
                });
                
                // Render grid view HTML
                $gridViewHtml = view('ideas._grid', compact('ideas'))->render();
                
                // Render list view HTML
                $listViewHtml = view('ideas._list', compact('ideas'))->render();
                
                // Render pagination
                $paginationHtml = $ideas->links('pagination.custom')->render();
                
                return response()->json([
                    'success' => true,
                    'ideas_html' => $viewMode === 'grid' ? $gridViewHtml : $listViewHtml,
                    'pagination_html' => $paginationHtml,
                    'total' => $ideas->total(),
                    'current_page' => $ideas->currentPage(),
                    'last_page' => $ideas->lastPage(),
                    'stats' => $stats
                ]);
            }

            // Regular page load
            return view('ideas.index', compact('ideas', 'categories', 'stats'));
        } catch (\Exception $e) {
            Log::error('Error filtering ideas', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error loading data: ' . $e->getMessage()
                ], 500);
            }
            
            return view('ideas.index', [
                'ideas' => collect([]),
                'categories' => collect([]),
                'stats' => [
                    'total' => 0, 'pending' => 0, 'in_progress' => 0, 
                    'completed' => 0, 'overdue' => 0, 'upcoming' => 0, 'favorites' => 0
                ],
                'error' => 'Error loading data: ' . $e->getMessage()
            ]);
        }
    }
}
