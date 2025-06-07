<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0a0a0f">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Idea Vault - Ultimate Ideal Experience</title>
    
    <!-- Custom Favicon -->
    <link rel="icon" href="/favicon.png" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Orbitron:wght@400;700;900&family=Noto+Sans+JP:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap');
        
        body {
            font-family: 'Inter', 'Noto Sans JP', sans-serif;
            background-color: #0a0a0f;
            background-image: 
                radial-gradient(circle at 25% 10%, rgba(77, 200, 244, 0.1) 0%, transparent 30%),
                radial-gradient(circle at 75% 90%, rgba(255, 107, 107, 0.1) 0%, transparent 30%);
            background-attachment: fixed;
        }
        
        .font-cyber {
            font-family: 'Orbitron', monospace;
        }
        
        .glass-effect {
            background: rgba(26, 26, 46, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        
        .neon-glow {
            box-shadow: 0 0 5px theme('colors.neon-pink'), 0 0 20px rgba(255, 107, 107, 0.3);
            transition: all 0.3s ease;
        }
        
        .neon-glow:hover {
            box-shadow: 0 0 10px theme('colors.neon-blue'), 0 0 30px rgba(78, 205, 196, 0.5);
        }
        
        .anime-input {
            background: rgba(16, 16, 26, 0.6);
            border: 1px solid rgba(78, 205, 196, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        
        .anime-input:focus {
            border-color: theme('colors.neon-pink');
            box-shadow: 0 0 0 2px rgba(255, 107, 107, 0.2);
            outline: none;
        }
        
        .card-hover {
            transition: all 0.3s ease;
            border-top: 3px solid transparent;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.5);
        }
        
        .priority-urgent {
            border-top: 3px solid #dc2626;
        }
        
        .priority-high {
            border-top: 3px solid #ea580c;
        }
        
        .priority-medium {
            border-top: 3px solid #eab308;
        }
        
        .priority-low {
            border-top: 3px solid #22c55e;
        }
        
        .status-pending {
            background: linear-gradient(90deg, #eab308, #ea580c);
        }
        
        .status-in_progress {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        }
        
        .status-completed {
            background: linear-gradient(90deg, #22c55e, #10b981);
        }
        
        .status-on_hold {
            background: linear-gradient(90deg, #64748b, #94a3b8);
        }
        
        /* Notification styling */
        #notifications {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            pointer-events: none;
        }
        
        .notification {
            margin-bottom: 10px;
            animation: slideInRight 0.3s ease-out forwards;
            pointer-events: auto;
        }
        
        .notification-exit {
            animation: slideOutRight 0.3s ease-in forwards;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Modal animations */
        .modal-enter {
            animation: modalEnter 0.3s ease-out;
        }
        
        @keyframes modalEnter {
            from {
                transform: scale(0.95);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        /* Filter tags */
        .filter-tag {
            animation: tagPop 0.3s ease-out;
        }
        
        @keyframes tagPop {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .refresh-animation {
            animation: refreshSpin 0.8s linear infinite;
        }
        
        @keyframes refreshSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Transitions for content updates */
        .content-fade-enter {
            animation: contentFade 0.4s ease-out;
        }
        
        @keyframes contentFade {
            0% { opacity: 0; transform: translateY(5px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
    
    <script>
        // Setup CSRF token handling for all AJAX requests
        document.addEventListener('DOMContentLoaded', function() {
            // Get the CSRF token from the meta tag
            window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Create a fetch interceptor for AJAX requests
            const originalFetch = window.fetch;
            window.fetch = function(url, options = {}) {
                options = options || {};
                options.headers = options.headers || {};
                
                // Add CSRF token to all non-GET requests
                const method = options.method ? options.method.toUpperCase() : 'GET';
                if (method !== 'GET') {
                    options.headers['X-CSRF-TOKEN'] = window.csrfToken;
                }
                
                // Add AJAX header to identify AJAX requests
                options.headers['X-Requested-With'] = 'XMLHttpRequest';
                
                return originalFetch(url, options);
            };

            console.log('CSRF token initialized:', window.csrfToken);
        });

        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'cyber-dark': '#0a0a0f',
                        'cyber-primary': '#1a1a2e',
                        'cyber-secondary': '#16213e',
                        'neon-pink': '#ff6b6b',
                        'neon-blue': '#4ecdc4',
                        'neon-purple': '#667eea',
                    },
                    fontFamily: {
                        'cyber': ['Orbitron', 'monospace'],
                        'anime': ['Inter', 'Noto Sans JP', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cyber-dark text-white min-h-screen overflow-x-hidden" 
      x-data="ideaVault()" 
      x-init="initializeApp()">
    <!-- Notifications container -->
    <div id="notifications" class="fixed top-6 right-6 z-50 max-w-sm space-y-2"></div>
    
    <!-- Header -->
    <header class="py-6">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="text-2xl md:text-3xl font-cyber font-bold text-white">
                        <span class="relative inline-block w-16 h-16 align-middle">
                            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 64 64" fill="none">
                                <defs>
                                    <linearGradient id="lamp-gradient" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#fffbe6"/>
                                        <stop offset="100%" stop-color="#fde047"/>
                                    </linearGradient>
                                    <radialGradient id="lamp-glow" cx="50%" cy="60%" r="60%">
                                        <stop offset="0%" stop-color="#fffde4" stop-opacity="0.7"/>
                                        <stop offset="100%" stop-color="#fde047" stop-opacity="0"/>
                                    </radialGradient>
                                </defs>
                                <!-- Glow (animated pulse and flicker) -->
                                <ellipse cx="32" cy="44" rx="20" ry="12" fill="url(#lamp-glow)">
                                    <animate attributeName="rx" values="18;22;18" dur="1.2s" repeatCount="indefinite"/>
                                    <animate attributeName="opacity" values="0.7;1;0.7" dur="1.2s" repeatCount="indefinite"/>
                                </ellipse>
                                <!-- Bulb (animated subtle scale) -->
                                <ellipse cx="32" cy="28" rx="14" ry="16" fill="url(#lamp-gradient)" stroke="#facc15" stroke-width="3">
                                    <animateTransform attributeName="transform" type="scale" additive="sum"
                                        values="1 1;1.04 1.04;1 1" keyTimes="0;0.5;1" dur="1.2s" repeatCount="indefinite"
                                        origin="32 28"/>
                                </ellipse>
                                <!-- Base (animated color flicker) -->
                                <rect x="26" y="44" width="12" height="8" rx="4">
                                    <animate attributeName="fill" values="#facc15;#fde047;#facc15" dur="0.8s" repeatCount="indefinite"/>
                                </rect>
                                <!-- Filament (animated flicker) -->
                                <path d="M32 36v4" stroke="#f59e42" stroke-width="3" stroke-linecap="round">
                                    <animate attributeName="stroke" values="#f59e42;#fbbf24;#f59e42" dur="0.4s" repeatCount="indefinite"/>
                                </path>
                                <!-- Sparkle effect -->
                                <g>
                                    <circle cx="32" cy="16" r="2" fill="#fffbe6">
                                        <animate attributeName="r" values="2;4;2" dur="1.2s" repeatCount="indefinite"/>
                                        <animate attributeName="opacity" values="1;0.5;1" dur="1.2s" repeatCount="indefinite"/>
                                    </circle>
                                    <circle cx="40" cy="22" r="1.2" fill="#fde047">
                                        <animate attributeName="r" values="1.2;2;1.2" dur="1.2s" repeatCount="indefinite" begin="0.3s"/>
                                        <animate attributeName="opacity" values="1;0.3;1" dur="1.2s" repeatCount="indefinite" begin="0.3s"/>
                                    </circle>
                                </g>
                            </svg>
                        </span>
                    </div>
                    <h1 class="text-xl md:text-2xl font-bold">Idea Vault</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button @click="viewMode = 'grid'; saveViewMode('grid')" :class="{'text-neon-pink': viewMode === 'grid', 'text-gray-400': viewMode !== 'grid'}" title="Grid view">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button @click="viewMode = 'list'; saveViewMode('list')" :class="{'text-neon-pink': viewMode === 'list', 'text-gray-400': viewMode !== 'list'}" title="List view">
                        <i class="fas fa-list"></i>
                    </button>
                    <button @click="fetchIdeas()" :class="isRefreshing ? 'text-neon-blue' : 'text-gray-400'" :disabled="isRefreshing" title="Refresh">
                        <i class="fas fa-sync-alt" :class="{'refresh-animation': isRefreshing}"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Stats -->
    <section class="container mx-auto px-6 mb-8">
        <div class="glass-effect rounded-xl p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 text-center" id="stats-container">
                <div class="p-4 rounded-lg bg-cyber-secondary/50">
                    <h3 class="text-sm text-gray-400">Total</h3>
                    <p class="text-2xl font-bold stat-value" data-stat-key="total">{{ $stats['total'] }}</p>
                </div>
                <div class="p-4 rounded-lg bg-yellow-900/20 border-t-2 border-yellow-500/50">
                    <h3 class="text-sm text-gray-400">Pending</h3>
                    <p class="text-2xl font-bold stat-value" data-stat-key="pending">{{ $stats['pending'] }}</p>
                </div>
                <div class="p-4 rounded-lg bg-blue-900/20 border-t-2 border-blue-500/50">
                    <h3 class="text-sm text-gray-400">In Progress</h3>
                    <p class="text-2xl font-bold stat-value" data-stat-key="in_progress">{{ $stats['in_progress'] }}</p>
                </div>
                <div class="p-4 rounded-lg bg-green-900/20 border-t-2 border-green-500/50">
                    <h3 class="text-sm text-gray-400">Completed</h3>
                    <p class="text-2xl font-bold stat-value" data-stat-key="completed">{{ $stats['completed'] }}</p>
                </div>
                <div class="p-4 rounded-lg bg-red-900/20 border-t-2 border-red-500/50">
                    <h3 class="text-sm text-gray-400">Overdue</h3>
                    <p class="text-2xl font-bold stat-value" data-stat-key="overdue">{{ $stats['overdue'] }}</p>
                </div>
                <div class="p-4 rounded-lg bg-purple-900/20 border-t-2 border-purple-500/50">
                    <h3 class="text-sm text-gray-400">Upcoming</h3>
                    <p class="text-2xl font-bold stat-value" data-stat-key="upcoming">{{ $stats['upcoming'] }}</p>
                </div>
                <div class="p-4 rounded-lg bg-pink-900/20 border-t-2 border-pink-500/50">
                    <h3 class="text-sm text-gray-400">Favorites</h3>
                    <p class="text-2xl font-bold stat-value" data-stat-key="favorites">{{ $stats['favorites'] }}</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Filters -->
    <section class="container mx-auto px-6 mb-8">
        <div class="glass-effect rounded-xl p-6">
            <div class="flex flex-wrap gap-4 items-center mb-4">
                <!-- Search Box -->
                <div class="relative flex-1 min-w-[240px]">
                    <form @submit.prevent="search()" class="w-full" id="search-form">
                        <input 
                            type="text" 
                            x-model="searchQuery" 
                            placeholder="Search ideas..." 
                            class="anime-input w-full pl-10 pr-4 py-2 rounded-lg"
                        >
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                        <button 
                            type="submit"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-neon-pink hover:text-white"
                            title="Search"
                        >
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
                
                <!-- Add Idea Button -->
                <button 
                    id="new-idea-btn"
                    @click="openModal('add')"
                    class="bg-gradient-to-r from-neon-pink to-neon-blue hover:from-neon-blue hover:to-neon-pink px-6 py-2 rounded-lg font-semibold transition-all duration-300 neon-glow"
                >
                    <i class="fas fa-plus mr-2"></i>
                    New Idea
                </button>
            </div>
            
            <!-- Filter Controls -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Status</label>
                    <select 
                        x-model="filters.status" 
                        @change="applyFilters()"
                        class="anime-input w-full rounded-lg px-3 py-2"
                    >
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="on_hold">On Hold</option>
                    </select>
                </div>
                
                <!-- Priority Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Priority</label>
                    <select 
                        x-model="filters.priority" 
                        @change="applyFilters()"
                        class="anime-input w-full rounded-lg px-3 py-2"
                    >
                        <option value="">All Priorities</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
                
                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Category</label>
                    <select 
                        x-model="filters.category" 
                        @change="applyFilters()"
                        class="anime-input w-full rounded-lg px-3 py-2"
                    >
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Sort By -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Sort By</label>
                    <select 
                        x-model="sorting.by" 
                        @change="applySorting()"
                        class="anime-input w-full rounded-lg px-3 py-2"
                    >
                        <option value="created_at">Creation Date</option>
                        <option value="title">Title</option>
                        <option value="priority">Priority</option>
                        <option value="status">Status</option>
                        <option value="due_date">Due Date</option>
                    </select>
                </div>
                
                <!-- Sort Direction & Favorites -->
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-400 mb-1">Order</label>
                        <button 
                            @click="toggleSortOrder()"
                            class="anime-input w-full rounded-lg px-3 py-2 flex items-center justify-between"
                            title="Toggle sort order"
                        >
                            <span x-text="sorting.order === 'asc' ? 'Ascending' : 'Descending'"></span>
                            <i class="fas" :class="sorting.order === 'asc' ? 'fa-sort-up' : 'fa-sort-down'"></i>
                        </button>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-400 mb-1">Show Only</label>
                        <button 
                            @click="filters.favorites = !filters.favorites; applyFilters()"
                            class="anime-input w-full rounded-lg px-3 py-2 flex items-center justify-between"
                            :class="{'bg-gradient-to-r from-pink-900/30 to-pink-700/20 border-pink-500/30': filters.favorites}"
                            title="Toggle favorites filter"
                        >
                            <span>Favorites</span>
                            <i class="fas fa-heart" :class="filters.favorites ? 'text-red-400' : 'text-gray-400'"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Active Filters -->
            <div class="mt-4" x-show="hasActiveFilters()">
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="text-sm text-gray-400">Active Filters:</span>
                    
                    <!-- Search Query Filter -->
                    <div 
                        x-show="searchQuery.trim()"
                        class="bg-cyber-secondary/50 rounded-full px-3 py-1 text-xs flex items-center filter-tag"
                    >
                        <span class="mr-2">Search: <span class="text-neon-pink" x-text="searchQuery"></span></span>
                        <button @click="searchQuery = ''; search()" class="text-gray-400 hover:text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <!-- Status Filter -->
                    <div 
                        x-show="filters.status"
                        class="bg-cyber-secondary/50 rounded-full px-3 py-1 text-xs flex items-center filter-tag"
                    >
                        <span class="mr-2">Status: <span class="text-neon-blue" x-text="formatFilterValue(filters.status)"></span></span>
                        <button @click="removeFilter('status')" class="text-gray-400 hover:text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <!-- Priority Filter -->
                    <div 
                        x-show="filters.priority"
                        class="bg-cyber-secondary/50 rounded-full px-3 py-1 text-xs flex items-center filter-tag"
                    >
                        <span class="mr-2">Priority: <span class="text-neon-blue" x-text="formatFilterValue(filters.priority)"></span></span>
                        <button @click="removeFilter('priority')" class="text-gray-400 hover:text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <!-- Category Filter -->
                    <div 
                        x-show="filters.category"
                        class="bg-cyber-secondary/50 rounded-full px-3 py-1 text-xs flex items-center filter-tag"
                    >
                        <span class="mr-2">Category: <span class="text-neon-blue" x-text="filters.category"></span></span>
                        <button @click="removeFilter('category')" class="text-gray-400 hover:text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <!-- Favorites Filter -->
                    <div 
                        x-show="filters.favorites"
                        class="bg-cyber-secondary/50 rounded-full px-3 py-1 text-xs flex items-center filter-tag"
                    >
                        <span class="mr-2">Favorites Only</span>
                        <button @click="removeFilter('favorites')" class="text-gray-400 hover:text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <!-- Sort By Tag -->
                    <div 
                        class="bg-cyber-secondary/50 rounded-full px-3 py-1 text-xs flex items-center filter-tag"
                    >
                        <span class="mr-2">Sort: <span class="text-neon-purple" x-text="formatSortLabel(sorting.by)"></span> 
                            <i class="fas" :class="sorting.order === 'asc' ? 'fa-arrow-up' : 'fa-arrow-down'"></i>
                        </span>
                    </div>
                    
                    <!-- Clear All Filters -->
                    <button 
                        @click="clearFilters()"
                        class="bg-red-900/20 text-red-400 hover:bg-red-900/40 hover:text-white rounded-full px-3 py-1 text-xs flex items-center transition-colors"
                    >
                        <i class="fas fa-times mr-1"></i> Clear All
                    </button>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Main Content -->
    <section class="container mx-auto px-6 mb-12" id="ideas-container">
        <h2 class="text-xl font-bold mb-6 flex items-center">
            <span>Ideas</span>
            <span class="ml-2 text-gray-400 text-sm font-normal">
                ({{ $ideas->total() }} {{ Str::plural('item', $ideas->total()) }})
            </span>
            <div x-show="isRefreshing" class="ml-3">
                <div class="loading-spinner"></div>
            </div>
        </h2>
        
        <div id="ideas-content">
            <!-- Grid View -->
            <div x-show="viewMode === 'grid'" :class="{'opacity-100': viewMode === 'grid', 'opacity-0 hidden': viewMode !== 'grid'}" x-transition>
                @include('ideas._grid', ['ideas' => $ideas])
            </div>
            
            <!-- List View -->
            <div x-show="viewMode === 'list'" :class="{'opacity-100': viewMode === 'list', 'opacity-0 hidden': viewMode !== 'list'}" x-transition>
                @include('ideas._list', ['ideas' => $ideas])
            </div>
        </div>
        
        <!-- Empty State -->
        @if($ideas->total() === 0)
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="text-6xl mb-4 text-gray-600">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">No ideas found</h3>
                <p class="text-gray-400 mb-6 max-w-md">
                    @if(request()->has('search') || request()->has('status') || request()->has('priority') || request()->has('category') || request()->has('favorites'))
                        No ideas match your current filters. Try adjusting your search criteria.
                    @else
                        You don't have any ideas yet. Start by adding your first idea!
                    @endif
                </p>
                @if(request()->has('search') || request()->has('status') || request()->has('priority') || request()->has('category') || request()->has('favorites'))
                    <button 
                        @click="clearFilters()"
                        class="bg-gradient-to-r from-neon-pink/80 to-neon-blue/80 hover:from-neon-blue/80 hover:to-neon-pink/80 px-6 py-2 rounded-lg font-semibold transition-all"
                    >
                        Clear Filters
                    </button>
                @else
                    <button 
                        @click="openModal('add')"
                        class="bg-gradient-to-r from-neon-pink to-neon-blue hover:from-neon-blue hover:to-neon-pink px-6 py-2 rounded-lg font-semibold transition-all neon-glow"
                    >
                        <i class="fas fa-plus mr-2"></i>
                        Add First Idea
                    </button>
                @endif
            </div>
        @endif
        
        <!-- Pagination -->
        <div class="mt-8" id="pagination-container">
            {{ $ideas->links('pagination.custom') }}
        </div>
    </section>
    
    <!-- Modal -->
    <div x-show="modal.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black opacity-75 transition-opacity" @click="closeModal()"></div>
            
            <div class="inline-block align-bottom glass-effect rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-enter">
                <form @submit.prevent="submitForm()">
                    <div class="px-6 pt-6 pb-4">
                        <h3 class="text-xl font-semibold text-white mb-6" x-text="modal.mode === 'add' ? 'Add New Idea' : 'Edit Idea'"></h3>
                        
                        <div class="space-y-4">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-300 mb-1">Title <span class="text-red-500">*</span></label>
                                <input 
                                    type="text" 
                                    id="title" 
                                    x-model="form.title" 
                                    class="anime-input w-full rounded-lg px-3 py-2"
                                    required
                                >
                            </div>
                            
                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-300 mb-1">Description <span class="text-red-500">*</span></label>
                                <textarea 
                                    id="description" 
                                    x-model="form.description" 
                                    class="anime-input w-full rounded-lg px-3 py-2 min-h-[100px]"
                                    required
                                ></textarea>
                            </div>
                            
                            <!-- Status and Priority -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                                    <select 
                                        id="status" 
                                        x-model="form.status" 
                                        class="anime-input w-full rounded-lg px-3 py-2"
                                    >
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="on_hold">On Hold</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-300 mb-1">Priority</label>
                                    <select 
                                        id="priority" 
                                        x-model="form.priority" 
                                        class="anime-input w-full rounded-lg px-3 py-2"
                                    >
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Tag and Category -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="tag" class="block text-sm font-medium text-gray-300 mb-1">Tag</label>
                                    <input 
                                        type="text" 
                                        id="tag" 
                                        x-model="form.tag" 
                                        class="anime-input w-full rounded-lg px-3 py-2"
                                    >
                                </div>
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-300 mb-1">Category</label>
                                    <input 
                                        type="text" 
                                        id="category" 
                                        x-model="form.category" 
                                        class="anime-input w-full rounded-lg px-3 py-2"
                                        list="category-list"
                                    >
                                    <datalist id="category-list">
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            
                            <!-- Estimated Hours and Completion -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="estimated_hours" class="block text-sm font-medium text-gray-300 mb-1">Estimated Hours</label>
                                    <input 
                                        type="number" 
                                        id="estimated_hours" 
                                        x-model="form.estimated_hours" 
                                        class="anime-input w-full rounded-lg px-3 py-2"
                                        min="0"
                                        step="0.5"
                                    >
                                </div>
                                <div>
                                    <label for="completion" class="block text-sm font-medium text-gray-300 mb-1">Completion %</label>
                                    <input 
                                        type="number" 
                                        id="completion" 
                                        x-model="form.completion_percentage" 
                                        class="anime-input w-full rounded-lg px-3 py-2"
                                        min="0"
                                        max="100"
                                    >
                                </div>
                            </div>
                            
                            <!-- Due Date -->
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-300 mb-1">Due Date</label>
                                <input 
                                    type="datetime-local" 
                                    id="due_date" 
                                    x-model="form.due_date" 
                                    class="anime-input w-full rounded-lg px-3 py-2"
                                >
                            </div>
                            
                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-300 mb-1">Notes</label>
                                <textarea 
                                    id="notes" 
                                    x-model="form.notes" 
                                    class="anime-input w-full rounded-lg px-3 py-2 min-h-[80px]"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-cyber-secondary/50 flex justify-end space-x-3">
                        <button type="button" @click="closeModal()" 
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit" :disabled="submitting"
                                class="px-6 py-2 bg-gradient-to-r from-neon-pink to-neon-blue hover:from-neon-blue hover:to-neon-pink rounded-lg font-semibold transition-all neon-glow">
                            <span x-show="!submitting" x-text="modal.mode === 'add' ? 'Create Idea' : 'Update Idea'"></span>
                            <span x-show="submitting" class="flex items-center">
                                <div class="loading-spinner mr-2"></div>
                                Processing...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div x-show="deleteModal.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black opacity-75 transition-opacity" @click="closeDeleteModal()"></div>
            
            <div class="inline-block align-bottom glass-effect rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-enter">
                <div class="px-6 pt-6 pb-4">
                    <h3 class="text-xl font-semibold text-white mb-4 text-center">Delete Idea</h3>
                    <div class="flex flex-col items-center mb-2">
                        <div class="text-neon-pink text-5xl mb-2">
                            <i class="fas fa-exclamation-triangle animate-pulse"></i>
                        </div>
                        <p class="text-gray-300 text-center">
                            Are you sure you want to delete this idea?
                        </p>
                    </div>
                    <p class="text-neon-pink font-semibold text-center" x-text="deleteModal.ideaTitle"></p>
                    <p class="text-neon-pink mt-4 text-sm font-semibold text-center">This action cannot be undone.</p>
                </div>
                
                <div class="px-6 py-4 bg-cyber-secondary/50 flex justify-end space-x-3">
                    <button @click="closeDeleteModal()" 
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button @click="confirmDelete()" :disabled="deleteModal.processing"
                            class="px-6 py-2 bg-gradient-to-r from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 rounded-lg font-semibold transition-colors">
                        <span x-show="!deleteModal.processing">Delete</span>
                        <span x-show="deleteModal.processing" class="flex items-center">
                            <div class="loading-spinner mr-2"></div>
                            Deleting...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Alpine.js Component -->
    <script>
        function ideaVault() {
            return {
                viewMode: localStorage.getItem('idea_vault_view_mode') || 'grid',
                loading: false,
                submitting: false,
                searchQuery: '{{ request()->get("search", "") }}',
                isRefreshing: false,
                totalIdeas: {{ $ideas->total() }},
                currentPage: {{ $ideas->currentPage() }},
                lastPage: {{ $ideas->lastPage() }},
                
                // Delete modal state
                deleteModal: {
                    show: false,
                    ideaId: null,
                    ideaTitle: '',
                    processing: false
                },
                
                // Modal state
                modal: {
                    show: false,
                    mode: 'add'
                },
                
                // Form data
                form: {
                    id: null,
                    title: '',
                    description: '',
                    status: 'pending',
                    priority: 'medium',
                    tag: '',
                    category: '',
                    estimated_hours: '',
                    completion_percentage: 0,
                    due_date: '',
                    notes: ''
                },
                
                // Filter and sort state
                filters: {
                    status: '{{ request()->get("status", "") }}',
                    priority: '{{ request()->get("priority", "") }}',
                    category: '{{ request()->get("category", "") }}',
                    favorites: {{ request()->get("favorites", false) ? 'true' : 'false' }},
                },
                
                sorting: {
                    by: '{{ request()->get("sort_by", "created_at") }}',
                    order: '{{ request()->get("sort_order", "desc") }}'
                },
                
                // Initialize the app
                initializeApp() {
                    console.log("Initializing IdeaVault app");
                    
                    // Parse URL parameters
                    this.parseUrlParams();
                    
                    // Setup pagination handlers
                    this.setupPaginationHandlers();

                    // Setup keyboard shortcut for escape key
                    window.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape') {
                            if (this.modal.show) {
                                this.closeModal();
                            } else if (this.deleteModal.show) {
                                this.closeDeleteModal();
                            }
                        }
                    });

                    // Debug info
                    console.log('Initial state:', {
                        viewMode: this.viewMode,
                        searchQuery: this.searchQuery,
                        filters: this.filters,
                        sorting: this.sorting
                    });
                },

                // Save view mode preference
                saveViewMode(mode) {
                    this.viewMode = mode;
                    localStorage.setItem('idea_vault_view_mode', mode);
                    this.fetchIdeas();
                },
                
                // Parse URL parameters to initialize state
                parseUrlParams() {
                    const params = new URLSearchParams(window.location.search);
                    
                    if (params.has('search')) {
                        this.searchQuery = params.get('search');
                    }
                    
                    if (params.has('status')) {
                        this.filters.status = params.get('status');
                    }
                    
                    if (params.has('priority')) {
                        this.filters.priority = params.get('priority');
                    }
                    
                    if (params.has('category')) {
                        this.filters.category = params.get('category');
                    }
                    
                    if (params.has('favorites')) {
                        this.filters.favorites = params.get('favorites') === 'true';
                    }
                    
                    if (params.has('sort_by')) {
                        this.sorting.by = params.get('sort_by');
                    }
                    
                    if (params.has('sort_order')) {
                        this.sorting.order = params.get('sort_order');
                    }
                    
                    if (params.has('page')) {
                        this.currentPage = parseInt(params.get('page'), 10);
                    }
                },
                
                // Setup pagination handlers
                setupPaginationHandlers() {
                    document.addEventListener('click', (e) => {
                        const link = e.target.closest('.page-link');
                        if (link && !link.classList.contains('disabled')) {
                            e.preventDefault();
                            const url = new URL(link.href);
                            this.currentPage = parseInt(url.searchParams.get('page') || '1', 10);
                            this.updateUrlAndRefresh();
                        }
                    });
                },
                
                // Search functionality
                search() {
                    console.log('Search triggered with query:', this.searchQuery);
                    this.currentPage = 1; // Reset to first page
                    this.updateUrlAndRefresh();
                },
                
                // Apply filters
                applyFilters() {
                    console.log('Applying filters:', this.filters);
                    this.currentPage = 1; // Reset to first page when filters change
                    this.updateUrlAndRefresh();
                },
                
                // Apply sorting
                applySorting() {
                    console.log('Applying sorting:', this.sorting);
                    this.updateUrlAndRefresh();
                },
                
                // Toggle sort order
                toggleSortOrder() {
                    this.sorting.order = this.sorting.order === 'asc' ? 'desc' : 'asc';
                    this.applySorting();
                },
                
                // Remove a specific filter
                removeFilter(filterName) {
                    if (filterName === 'favorites') {
                        this.filters.favorites = false;
                    } else {
                        this.filters[filterName] = '';
                    }
                    this.applyFilters();
                },
                
                // Clear all filters
                clearFilters() {
                    this.filters = {
                        status: '',
                        priority: '',
                        category: '',
                        favorites: false
                    };
                    this.searchQuery = '';
                    this.currentPage = 1;
                    this.updateUrlAndRefresh();
                },
                
                // Check if any filters are active
                hasActiveFilters() {
                    return this.filters.status || this.filters.priority || this.filters.category || 
                           this.filters.favorites || this.searchQuery;
                },
                
                // Format filter values for display
                formatFilterValue(value) {
                    if (!value) return '';
                    return value.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                },
                
                // Format sorting labels
                formatSortLabel(sortBy) {
                    const labels = {
                        'created_at': 'Creation Date',
                        'title': 'Title',
                        'priority': 'Priority',
                        'status': 'Status',
                        'due_date': 'Due Date'
                    };
                    return labels[sortBy] || sortBy;
                },
                
                // Update URL and refresh content
                updateUrlAndRefresh() {
                    // Create query params object
                    const params = new URLSearchParams();
                    
                    // Add search if present
                    if (this.searchQuery.trim()) {
                        params.set('search', this.searchQuery.trim());
                    }
                    
                    // Add filters to URL
                    if (this.filters.status) {
                        params.set('status', this.filters.status);
                    }
                    
                    if (this.filters.priority) {
                        params.set('priority', this.filters.priority);
                    }
                    
                    if (this.filters.category) {
                        params.set('category', this.filters.category);
                    }
                    
                    if (this.filters.favorites) {
                        params.set('favorites', 'true');
                    }
                    
                    // Add sorting to URL
                    params.set('sort_by', this.sorting.by);
                    params.set('sort_order', this.sorting.order);
                    
                    // Add current page
                    if (this.currentPage > 1) {
                        params.set('page', this.currentPage);
                    }
                    
                    // Update URL without reloading
                    const newUrl = `${window.location.pathname}?${params.toString()}`;
                    window.history.pushState({ path: newUrl }, '', newUrl);
                    
                    // Refresh content
                    this.fetchIdeas();
                },
                
                // Fetch ideas with better error handling
                async fetchIdeas() {
                    this.isRefreshing = true;
                    
                    try {
                        // Build query params
                        const params = new URLSearchParams(window.location.search);
                        
                        // Add view mode
                        params.set('view_mode', this.viewMode);
                        
                        console.log('Fetching ideas with params:', params.toString());
                        
                        const response = await fetch(`/api/ideas/filter?${params.toString()}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error('Error fetching ideas:', {
                                status: response.status,
                                statusText: response.statusText,
                                responseText: errorText
                            });
                            throw new Error(`Error ${response.status}: ${response.statusText}`);
                        }
                        
                        const data = await response.json();
                        
                        // Update content
                        document.getElementById('ideas-content').innerHTML = data.ideas_html;
                        document.getElementById('pagination-container').innerHTML = data.pagination_html;
                        this.totalIdeas = data.total;
                        this.currentPage = data.current_page;
                        this.lastPage = data.last_page;
                        
                        // Update stats if available
                        if (data.stats) {
                            this.updateStats(data.stats);
                        }
                        
                        // Re-initialize Alpine components in the updated content
                        if (window.Alpine) {
                            setTimeout(() => {
                                window.Alpine.initTree(document.getElementById('ideas-content'));
                            }, 50);
                        }
                    } catch (error) {
                        console.error('Error fetching ideas:', error);
                        this.showNotification('Failed to refresh content: ' + error.message, 'error');
                    } finally {
                        this.isRefreshing = false;
                    }
                },
                
                // Update stats widget with new values
                updateStats(stats) {
                    const statsElements = document.querySelectorAll('#stats-container .stat-value');
                    if (statsElements.length) {
                        statsElements.forEach(el => {
                            const statKey = el.getAttribute('data-stat-key');
                            if (stats[statKey] !== undefined) {
                                el.textContent = stats[statKey];
                            }
                        });
                    }
                },
                
                // Modal handlers
                openModal(mode, idea = null) {
                    console.log(`Opening modal in ${mode} mode`, idea);
                    this.modal.mode = mode;
                    
                    try {
                        // Reset form before setting new data
                        this.resetForm();
                        
                        if (mode === 'edit' && idea) {
                            console.log("Setting form data for edit:", idea);
                            // First stringify then parse to create a deep copy
                            this.form = JSON.parse(JSON.stringify(idea));
                            
                            // Ensure ID is set correctly
                            if (!this.form.id && idea.id) {
                                this.form.id = idea.id;
                            }
                            
                            // Format due date for datetime-local input if it exists
                            if (this.form.due_date) {
                                try {
                                    // Handle different date formats
                                    const dateObj = new Date(this.form.due_date);
                                    if (!isNaN(dateObj.getTime())) {
                                        this.form.due_date = dateObj.toISOString().slice(0, 16);
                                    }
                                } catch (e) {
                                    console.error("Error formatting date:", e);
                                }
                            }
                            
                            console.log("Form data set:", this.form);
                        }
                        
                        // Show the modal after setting up form data
                        this.modal.show = true;
                    } catch (error) {
                        console.error("Error preparing form data:", error);
                        this.showNotification("Error preparing form data. Please try again.", "error");
                    }
                },
                
                closeModal() {
                    this.modal.show = false;
                    setTimeout(() => {
                        this.resetForm();
                    }, 300);
                },
                
                resetForm() {
                    this.form = {
                        id: null,
                        title: '',
                        description: '',
                        tag: '',
                        status: 'pending',
                        priority: 'medium',
                        category: '',
                        estimated_hours: '',
                        completion_percentage: 0,
                        due_date: '',
                        notes: ''
                    };
                },
                
                // Submit form with AJAX
                async submitForm() {
                    if (!this.validateForm()) {
                        return;
                    }
                    
                    this.submitting = true;
                    
                    try {
                        const url = this.modal.mode === 'add' 
                            ? '/ideas' 
                            : `/ideas/${this.form.id}`;
                        
                        const method = this.modal.mode === 'add' ? 'POST' : 'PUT';
                        
                        console.log('Submitting form:', this.form);
                        console.log('URL:', url, 'Method:', method);
                        
                        // Get CSRF token
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        // Submit request
                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.form)
                        });
                        
                        const data = await response.json();
                        
                        if (!response.ok) {
                            if (data.errors) {
                                const errorMessages = Object.values(data.errors).flat();
                                throw new Error(errorMessages.join(', '));
                            }
                            throw new Error(data.message || `Error ${response.status}: ${response.statusText}`);
                        }
                        
                        if (data.success) {
                            this.showNotification(data.message || 'Operation completed successfully', 'success');
                            this.closeModal();
                            this.fetchIdeas(); // Refresh the content
                        } else {
                            throw new Error(data.message || 'Something went wrong');
                        }
                    } catch (error) {
                        console.error('Form submission error:', error);
                        this.showNotification(error.message || 'Failed to save idea', 'error');
                    } finally {
                        this.submitting = false;
                    }
                },
                
                // Validate the form before submission
                validateForm() {
                    if (!this.form.title || !this.form.title.trim()) {
                        this.showNotification('Title is required', 'error');
                        return false;
                    }
                    
                    if (!this.form.description || !this.form.description.trim()) {
                        this.showNotification('Description is required', 'error');
                        return false;
                    }
                    
                    return true;
                },
                
                // Delete idea (opens delete modal)
                deleteIdea(id, title = 'Untitled Idea') {
                    this.openDeleteModal(id, title);
                },
                
                // Delete modal handlers
                openDeleteModal(id, title) {
                    console.log('Opening delete modal for idea:', id, title);
                    this.deleteModal.ideaId = id;
                    this.deleteModal.ideaTitle = title || 'Untitled Idea';
                    this.deleteModal.processing = false;
                    this.deleteModal.show = true;
                },
                
                closeDeleteModal() {
                    this.deleteModal.show = false;
                    setTimeout(() => {
                        this.deleteModal.ideaId = null;
                        this.deleteModal.ideaTitle = '';
                    }, 300);
                },
                
                // Confirm delete with AJAX
                async confirmDelete() {
                    if (!this.deleteModal.ideaId) return;
                    
                    this.deleteModal.processing = true;
                    
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        console.log('Deleting idea:', this.deleteModal.ideaId);
                        
                        const response = await fetch(`/ideas/${this.deleteModal.ideaId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (!response.ok) {
                            const errorText = await response.text();
                            throw new Error(`Error ${response.status}: ${response.statusText}`);
                        }
                        
                        const data = await response.json();
                        
                        this.showNotification(data.message || 'Idea deleted successfully', 'success');
                        this.closeDeleteModal();
                        this.fetchIdeas(); // Refresh the content
                    } catch (error) {
                        console.error('Error deleting idea:', error);
                        this.showNotification(error.message || 'Failed to delete idea', 'error');
                    } finally {
                        this.deleteModal.processing = false;
                    }
                },
                
                // Toggle favorite with AJAX
                async toggleFavorite(id) {
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        console.log('Toggling favorite status for idea:', id);
                        
                        const response = await fetch(`/api/ideas/${id}/toggle-favorite`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        
                        if (!response.ok) {
                            const errorText = await response.text();
                            throw new Error(`Error ${response.status}: ${response.statusText}`);
                        }
                        
                        const data = await response.json();
                        
                        this.showNotification(data.message || (data.is_favorite ? 'Added to favorites' : 'Removed from favorites'), 'success');
                        this.fetchIdeas(); // Refresh content to reflect changes
                    } catch (error) {
                        console.error('Error updating favorite status:', error);
                        this.showNotification(error.message || 'Failed to update favorite status', 'error');
                    }
                },
                
                // Notification system
                showNotification(message, type = 'info') {
                    const notification = document.createElement('div');
                    notification.className = `notification p-4 rounded-lg shadow-lg mb-2 ${type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600'} text-white`;
                    notification.innerHTML = `
                        <div class="flex items-center justify-between">
                            <span>${message}</span>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    
                    const notificationsContainer = document.getElementById('notifications');
                    if (notificationsContainer) {
                        notificationsContainer.appendChild(notification);
                        
                        setTimeout(() => {
                            notification.classList.add('notification-exit');
                            setTimeout(() => notification.remove(), 500);
                        }, 5000);
                    }
                }
            };
        }
    </script>
</body>
</html>
