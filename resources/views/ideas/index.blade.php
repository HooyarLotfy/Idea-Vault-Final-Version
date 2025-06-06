<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Idea Vault - Ultimate Anime Experience</title>
    
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
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap');
        
        :root {
            --primary-glow: #ff6b6b;
            --secondary-glow: #4ecdc4;
            --accent-glow: #45b7d1;
            --bg-primary: #0a0a0f;
            --bg-secondary: #1a1a2e;
            --bg-card: #16213e;
        }

        * {
            font-family: 'Inter', 'Noto Sans JP', sans-serif;
        }

        .anime-title {
            font-family: 'Orbitron', monospace;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #ffeaa7);
            background-size: 400% 400%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .glass-effect {
            background: rgba(22, 33, 62, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .neon-glow {
            box-shadow: 0 0 20px rgba(255, 107, 107, 0.3), 0 0 40px rgba(78, 205, 196, 0.2);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
        }

        .card-hover:hover {
            transform: translateY(-8px) rotateX(5deg);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4), 0 0 30px rgba(255, 107, 107, 0.2);
        }

        .anime-input {
            background: linear-gradient(135deg, rgba(22, 33, 62, 0.8), rgba(26, 26, 46, 0.9));
            /* Change the background color to a darker shade */
            background-color: #333;
            border: 1px solid rgba(255, 107, 107, 0.3);
            transition: all 0.3s ease;
        }

        .anime-input:focus {
            border-color: #ff6b6b;
            box-shadow: 0 0 20px rgba(255, 107, 107, 0.4);
            outline: none;
        }

        .floating-elements {
            position: fixed;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: radial-gradient(circle, #ff6b6b, transparent);
            border-radius: 50%;
            animation: float 6s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
        }

        .status-pending { background: linear-gradient(135deg, #ffd93d, #ff9500); }
        .status-in_progress { background: linear-gradient(135deg, #667eea, #764ba2); }
        .status-completed { background: linear-gradient(135deg, #56ab2f, #a8e6cf); }
        .status-on_hold { background: linear-gradient(135deg, #536976, #292e49); }

        .priority-low { border-left: 4px solid #56ab2f; }
        .priority-medium { border-left: 4px solid #ffd93d; }
        .priority-high { border-left: 4px solid #ff9500; }
        .priority-urgent { border-left: 4px solid #ff6b6b; }

        .cyber-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .cyber-scroll::-webkit-scrollbar-track {
            background: rgba(22, 33, 62, 0.3);
            border-radius: 4px;
        }

        .cyber-scroll::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border-radius: 4px;
        }

        .loading-spinner {
            border: 3px solid rgba(255, 107, 107, 0.3);
            border-top: 3px solid #ff6b6b;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .modal-enter {
            animation: modalEnter 0.3s ease-out;
        }

        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .notification {
            animation: slideInRight 0.5s ease-out;
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
    </style>
    
    <script>
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
                    },
                    animation: {
                        'gradient': 'gradientShift 3s ease infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cyber-dark text-white min-h-screen overflow-x-hidden" 
      x-data="ideaVault()" 
      x-init="init()">
    
    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <div class="floating-particle" style="top: 10%; left: 10%; animation-delay: 0s;"></div>
        <div class="floating-particle" style="top: 20%; left: 80%; animation-delay: 1s;"></div>
        <div class="floating-particle" style="top: 60%; left: 20%; animation-delay: 2s;"></div>
        <div class="floating-particle" style="top: 80%; left: 70%; animation-delay: 3s;"></div>
        <div class="floating-particle" style="top: 40%; left: 90%; animation-delay: 4s;"></div>
    </div>
    
    <!-- Header -->
    <header class="glass-effect sticky top-0 z-50 border-b border-neon-pink/20">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="/favicon.png" alt="Idea Vault Logo" style="width: 48px; height: 48px;">
                    <h1 class="text-3xl font-cyber anime-title font-black">
                        IDEA VAULT
                    </h1>
                </div>
                
                <div class="flex items-center space-x-4">
         
                    
                    <!-- Add Idea Button -->
                    <button 
                        @click="openModal('add')"
                        class="bg-gradient-to-r from-neon-pink to-neon-blue hover:from-neon-blue hover:to-neon-pink px-6 py-2 rounded-lg font-semibold transition-all duration-300 neon-glow"
                    >
                        <i class="fas fa-plus mr-2"></i>
                        New Idea
                    </button>
                    
                    <!-- View Toggle -->
                    <div class="flex bg-cyber-secondary rounded-lg p-1">
                        <button 
                            @click="viewMode = 'grid'"
                            :class="viewMode === 'grid' ? 'bg-neon-pink text-white' : 'text-gray-400'"
                            class="px-3 py-1 rounded transition-all"
                        >
                            <i class="fas fa-th"></i>
                        </button>
                        <button 
                            @click="viewMode = 'list'"
                            :class="viewMode === 'list' ? 'bg-neon-pink text-white' : 'text-gray-400'"
                            class="px-3 py-1 rounded transition-all"
                        >
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Dashboard Stats -->
    <section class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
            <div class="glass-effect rounded-xl p-4 text-center card-hover">
                <div class="text-2xl font-bold text-neon-pink">{{ $stats['total'] }}</div>
                <div class="text-sm text-gray-400">Total Ideas</div>
            </div>
            <div class="glass-effect rounded-xl p-4 text-center card-hover">
                <div class="text-2xl font-bold text-yellow-400">{{ $stats['pending'] }}</div>
                <div class="text-sm text-gray-400">Pending</div>
            </div>
            <div class="glass-effect rounded-xl p-4 text-center card-hover">
                <div class="text-2xl font-bold text-blue-400">{{ $stats['in_progress'] }}</div>
                <div class="text-sm text-gray-400">In Progress</div>
            </div>
            <div class="glass-effect rounded-xl p-4 text-center card-hover">
                <div class="text-2xl font-bold text-green-400">{{ $stats['completed'] }}</div>
                <div class="text-sm text-gray-400">Completed</div>
            </div>
            <div class="glass-effect rounded-xl p-4 text-center card-hover">
                <div class="text-2xl font-bold text-red-400">{{ $stats['overdue'] }}</div>
                <div class="text-sm text-gray-400">Overdue</div>
            </div>
            <div class="glass-effect rounded-xl p-4 text-center card-hover">
                <div class="text-2xl font-bold text-purple-400">{{ $stats['upcoming'] }}</div>
                <div class="text-sm text-gray-400">Upcoming</div>
            </div>
            <div class="glass-effect rounded-xl p-4 text-center card-hover">
                <div class="text-2xl font-bold text-pink-400">{{ $stats['favorites'] }}</div>
                <div class="text-sm text-gray-400">Favorites</div>
            </div>
        </div>
    </section>
    
    <!-- Filters -->
    <section class="container mx-auto px-6 mb-8">
        <div class="glass-effect rounded-xl p-6">
            <div class="flex flex-wrap gap-4 items-center">
                <select x-model="filters.status" @change="applyFilters" class="anime-input px-4 py-2 rounded-lg">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="on_hold">On Hold</option>
                </select>
                
                <select x-model="filters.priority" @change="applyFilters" class="anime-input px-4 py-2 rounded-lg">
                    <option value="">All Priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent</option>
                </select>
                
                <select x-model="filters.category" @change="applyFilters" class="anime-input px-4 py-2 rounded-lg">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
                
                <button 
                    @click="filters.favorites = !filters.favorites; applyFilters()"
                    :class="filters.favorites ? 'bg-neon-pink' : 'bg-cyber-secondary'"
                    class="px-4 py-2 rounded-lg transition-all"
                >
                    <i class="fas fa-heart mr-2"></i>
                    Favorites
                </button>
                
                <button @click="clearFilters()" class="px-4 py-2 rounded-lg bg-cyber-secondary hover:bg-gray-600 transition-all">
                    <i class="fas fa-times mr-2"></i>
                    Clear
                </button>
            </div>
        </div>
    </section>
    
    <!-- Ideas Grid/List -->
    <main class="container mx-auto px-6 pb-12">
        <div x-show="loading" class="flex justify-center py-12">
            <div class="loading-spinner"></div>
        </div>
        
        <div x-show="!loading">
            <!-- Grid View -->
            <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($ideas as $idea)
                    <div class="glass-effect rounded-xl overflow-hidden card-hover priority-{{ $idea->priority ?? 'medium' }}" 
                         x-data="{ idea: @js($idea) }">
                        
                        <!-- Card Header -->
                        <div class="status-{{ $idea->status }} h-1"></div>
                        
                        <div class="p-6">
                            <!-- Title and Actions -->
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="text-lg font-semibold text-white truncate flex-1 mr-2">
                                    {{ $idea->title }}
                                </h3>
                                <div class="flex space-x-1">
                                    <button 
                                        @click="toggleFavorite({{ $idea->id }})"
                                        class="text-{{ $idea->is_favorite ? 'red' : 'gray' }}-400 hover:text-red-400 transition-colors"
                                    >
                                        <i class="fas fa-heart"></i>
                                    </button>
                                    <button @click="openModal('edit', idea)" class="text-gray-400 hover:text-neon-blue transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="deleteIdea({{ $idea->id }})" class="text-gray-400 hover:text-red-400 transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <p class="text-gray-300 text-sm mb-4 line-clamp-3">
                                {{ $idea->description }}
                            </p>
                            
                            <!-- Progress Bar -->
                            @if($idea->completion_percentage > 0)
                                <div class="mb-4">
                                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                                        <span>Progress</span>
                                        <span>{{ $idea->completion_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-700 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-neon-pink to-neon-blue h-2 rounded-full transition-all duration-500" 
                                             style="width: {{ $idea->completion_percentage }}%"></div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Tags and Info -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                @if($idea->tag)
                                    <span class="bg-neon-blue/20 text-neon-blue px-2 py-1 rounded-full text-xs">
                                        {{ $idea->tag }}
                                    </span>
                                @endif
                                @if($idea->category)
                                    <span class="bg-purple-500/20 text-purple-400 px-2 py-1 rounded-full text-xs">
                                        {{ $idea->category }}
                                    </span>
                                @endif
                                @if($idea->priority)
                                    <span class="bg-{{ $idea->priority === 'urgent' ? 'red' : ($idea->priority === 'high' ? 'orange' : ($idea->priority === 'medium' ? 'yellow' : 'green')) }}-500/20 text-{{ $idea->priority === 'urgent' ? 'red' : ($idea->priority === 'high' ? 'orange' : ($idea->priority === 'medium' ? 'yellow' : 'green')) }}-400 px-2 py-1 rounded-full text-xs uppercase">
                                        {{ $idea->priority }}
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Footer -->
                            <div class="flex items-center justify-between text-xs text-gray-400">
                                <span>{{ $idea->created_at->diffForHumans() }}</span>
                                @if($idea->due_date)
                                    <span class="{{ $idea->is_overdue ? 'text-red-400' : 'text-gray-400' }}">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $idea->time_until_due }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- List View -->
            <div x-show="viewMode === 'list'" class="space-y-4">
                @foreach($ideas as $idea)
                    <div class="glass-effect rounded-xl p-6 card-hover priority-{{ $idea->priority ?? 'medium' }}" 
                         x-data="{ idea: @js($idea) }">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <h3 class="text-lg font-semibold text-white">{{ $idea->title }}</h3>
                                    <span class="status-{{ $idea->status }} px-3 py-1 rounded-full text-xs font-medium text-white">
                                        {{ ucfirst(str_replace('_', ' ', $idea->status)) }}
                                    </span>
                                    @if($idea->priority)
                                        <span class="text-xs px-2 py-1 rounded-full bg-{{ $idea->priority === 'urgent' ? 'red' : ($idea->priority === 'high' ? 'orange' : ($idea->priority === 'medium' ? 'yellow' : 'green')) }}-500/20 text-{{ $idea->priority === 'urgent' ? 'red' : ($idea->priority === 'high' ? 'orange' : ($idea->priority === 'medium' ? 'yellow' : 'green')) }}-400 uppercase">
                                            {{ $idea->priority }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-300 text-sm mt-2">{{ Str::limit($idea->description, 100) }}</p>
                                
                                @if($idea->completion_percentage > 0)
                                    <div class="flex items-center space-x-3 mt-3">
                                        <div class="flex-1 bg-gray-700 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-neon-pink to-neon-blue h-2 rounded-full" 
                                                 style="width: {{ $idea->completion_percentage }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $idea->completion_percentage }}%</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex items-center space-x-2 ml-6">
                                <button 
                                    @click="toggleFavorite({{ $idea->id }})"
                                    class="text-{{ $idea->is_favorite ? 'red' : 'gray' }}-400 hover:text-red-400 transition-colors p-2"
                                >
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button @click="openModal('edit', idea)" class="text-gray-400 hover:text-neon-blue transition-colors p-2">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button @click="deleteIdea({{ $idea->id }})" class="text-gray-400 hover:text-red-400 transition-colors p-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $ideas->links() }}
        </div>
    </main>
    
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
            <div class="fixed inset-0 bg-black opacity-75" @click="closeModal()"></div>
            
            <div class="inline-block align-bottom glass-effect rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-enter">
                <form @submit.prevent="submitForm()">
                    <div class="px-6 pt-6 pb-4">
                        <h3 class="text-xl font-semibold text-white mb-6" x-text="modal.mode === 'add' ? 'Add New Idea' : 'Edit Idea'"></h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Title</label>
                                <input type="text" x-model="form.title" required 
                                       class="anime-input w-full px-4 py-2 rounded-lg text-white">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                                <textarea x-model="form.description" required rows="4"
                                          class="anime-input w-full px-4 py-2 rounded-lg text-white resize-none"></textarea>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                                    <select x-model="form.status" class="anime-input w-full px-4 py-2 rounded-lg text-white">
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="on_hold">On Hold</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Priority</label>
                                    <select x-model="form.priority" class="anime-input w-full px-4 py-2 rounded-lg text-white">
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Tag</label>
                                    <input type="text" x-model="form.tag" 
                                           class="anime-input w-full px-4 py-2 rounded-lg text-white">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                                    <input type="text" x-model="form.category" 
                                           class="anime-input w-full px-4 py-2 rounded-lg text-white">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Due Date</label>
                                    <input type="datetime-local" x-model="form.due_date" 
                                           class="anime-input w-full px-4 py-2 rounded-lg text-white">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Estimated Hours</label>
                                    <input type="number" x-model="form.estimated_hours" step="0.5" min="0"
                                           class="anime-input w-full px-4 py-2 rounded-lg text-white">
                                </div>
                            </div>
                            
                            <div x-show="modal.mode === 'edit'">
                                <label class="block text-sm font-medium text-gray-300 mb-2">Completion Percentage</label>
                                <input type="range" x-model="form.completion_percentage" min="0" max="100" step="5"
                                       class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                                <div class="text-center text-sm text-gray-400 mt-1" x-text="form.completion_percentage + '%'"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Notes</label>
                                <textarea x-model="form.notes" rows="3"
                                          class="anime-input w-full px-4 py-2 rounded-lg text-white resize-none"></textarea>
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
    
    <!-- Notifications -->
    <div id="notifications" class="fixed top-4 right-4 z-50 space-y-2"></div>
    
    <script>
        function ideaVault() {
            return {
                viewMode: 'grid',
                loading: false,
                submitting: false,
                searchQuery: '',
                
                modal: {
                    show: false,
                    mode: 'add'
                },
                
                form: {
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
                },
                
                filters: {
                    status: '',
                    priority: '',
                    category: '',
                    favorites: false
                },
                
                init() {
                    // Set CSRF token for AJAX requests
                    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                },
                
                openModal(mode, idea = null) {
                    this.modal.mode = mode;
                    this.modal.show = true;
                    
                    if (mode === 'edit' && idea) {
                        this.form = { ...idea };
                        if (this.form.due_date) {
                            this.form.due_date = new Date(this.form.due_date).toISOString().slice(0, 16);
                        }
                    } else {
                        this.resetForm();
                    }
                },
                
                closeModal() {
                    this.modal.show = false;
                    this.resetForm();
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
                
                async submitForm() {
                    this.submitting = true;
                    
                    try {
                        const url = this.modal.mode === 'add' 
                            ? '/ideas' 
                            : `/ideas/${this.form.id}`;
                        
                        const method = this.modal.mode === 'add' ? 'POST' : 'PUT';
                        
                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.form)
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            this.showNotification(data.message, 'success');
                            this.closeModal();
                            window.location.reload(); // Simple reload for now
                        } else {
                            throw new Error(data.message || 'Something went wrong');
                        }
                    } catch (error) {
                        this.showNotification(error.message || 'Failed to save idea', 'error');
                    } finally {
                        this.submitting = false;
                    }
                },
                
                async deleteIdea(id) {
                    if (!confirm('Are you sure you want to delete this idea?')) return;
                    
                    try {
                        const response = await fetch(`/ideas/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            this.showNotification(data.message, 'success');
                            window.location.reload();
                        }
                    } catch (error) {
                        this.showNotification('Failed to delete idea', 'error');
                    }
                },
                
                async toggleFavorite(id) {
                    try {
                        const response = await fetch(`/api/ideas/${id}/toggle-favorite`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            // Update the UI without reload
                            const heartIcon = document.querySelector(`[onclick="toggleFavorite(${id})"] i`);
                            if (heartIcon) {
                                heartIcon.className = data.is_favorite ? 'fas fa-heart text-red-400' : 'fas fa-heart text-gray-400';
                            }
                        }
                    } catch (error) {
                        this.showNotification('Failed to update favorite', 'error');
                    }
                },
                
                search() {
                    // Implement search functionality
                    const params = new URLSearchParams(window.location.search);
                    if (this.searchQuery) {
                        params.set('search', this.searchQuery);
                    } else {
                        params.delete('search');
                    }
                    window.history.replaceState({}, '', `${window.location.pathname}?${params}`);
                    window.location.reload();
                },
                
                applyFilters() {
                    const params = new URLSearchParams();
                    
                    Object.keys(this.filters).forEach(key => {
                        if (this.filters[key]) {
                            params.set(key, this.filters[key]);
                        }
                    });
                    
                    window.location.search = params.toString();
                },
                
                clearFilters() {
                    this.filters = {
                        status: '',
                        priority: '',
                        category: '',
                        favorites: false
                    };
                    window.location.search = '';
                },
                
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
                    
                    document.getElementById('notifications').appendChild(notification);
                    
                    setTimeout(() => {
                        notification.remove();
                    }, 5000);
                },
                
                debounce(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }
            }
        }
    </script>
</body>
</html>
