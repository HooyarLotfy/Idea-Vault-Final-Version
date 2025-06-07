<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($ideas as $idea)
        <div class="glass-effect rounded-xl overflow-hidden card-hover priority-{{ $idea->priority ?? 'medium' }}" 
             x-data="{ idea: {{ Illuminate\Support\Js::from($idea) }} }">
            
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
                            title="Toggle favorite"
                        >
                            <i class="fas fa-heart"></i>
                        </button>
                        <button 
                            @click="openModal('edit', idea)"
                            class="text-gray-400 hover:text-neon-blue transition-colors" 
                            title="Edit idea"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button 
                            @click="deleteIdea({{ $idea->id }}, '{{ addslashes($idea->title) }}')" 
                            class="text-gray-400 hover:text-red-400 transition-colors" 
                            title="Delete idea"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Description -->
                <p class="text-gray-300 text-sm mb-4">{{ Str::limit($idea->description, 100) }}</p>
                
                <!-- Meta Information -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @if($idea->category)
                        <span class="text-xs px-2 py-1 rounded-full bg-neon-blue/20 text-neon-blue">{{ $idea->category }}</span>
                    @endif
                    
                    @if($idea->tag)
                        <span class="text-xs px-2 py-1 rounded-full bg-neon-purple/20 text-neon-purple">{{ $idea->tag }}</span>
                    @endif
                </div>
                
                <!-- Progress bar if applicable -->
                @if($idea->completion_percentage > 0)
                    <div class="flex items-center space-x-3 mt-3">
                        <div class="flex-1 bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-neon-pink to-neon-blue h-2 rounded-full" 
                                 style="width: {{ $idea->completion_percentage }}%"></div>
                        </div>
                        <span class="text-xs text-gray-400">{{ $idea->completion_percentage }}%</span>
                    </div>
                @endif
                
                <!-- Footer -->
                <div class="flex justify-between items-center mt-4 text-xs text-gray-400">
                    <span>{{ $idea->created_at->diffForHumans() }}</span>
                    
                    @if($idea->due_date)
                        <span class="{{ \Carbon\Carbon::parse($idea->due_date)->isPast() && $idea->status !== 'completed' ? 'text-red-400' : '' }}">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            {{ \Carbon\Carbon::parse($idea->due_date)->format('M d, Y') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
    /* Define a minimum grid item height */
    .card-grid > div {
        min-height: 180px;
        display: flex;
        flex-direction: column;
    }
    
    .card-grid > div > div:last-child {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-grid > div > div:last-child > div:last-child {
        margin-top: auto;
    }
    
    /* Text size adjustments */
    @media (max-width: 374px) {
        .text-xxs {
            font-size: 0.65rem;
        }
    }
</style>
