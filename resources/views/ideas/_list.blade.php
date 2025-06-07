<div class="space-y-4">
    @foreach($ideas as $idea)
        <div class="glass-effect rounded-xl p-6 card-hover priority-{{ $idea->priority ?? 'medium' }}" 
             x-data="{ idea: {{ Illuminate\Support\Js::from($idea) }} }">
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
                </div>
                
                <div class="flex items-center space-x-2 ml-6">
                    <button 
                        @click="toggleFavorite({{ $idea->id }})"
                        class="text-{{ $idea->is_favorite ? 'red' : 'gray' }}-400 hover:text-red-400 transition-colors p-2"
                    >
                        <i class="fas fa-heart"></i>
                    </button>
                    <button 
                        @click="openModal('edit', idea)"
                        class="text-gray-400 hover:text-neon-blue transition-colors p-2"
                    >
                        <i class="fas fa-edit"></i>
                    </button>
                    <button 
                        @click="deleteIdea({{ $idea->id }}, '{{ addslashes($idea->title) }}')" 
                        class="text-gray-400 hover:text-red-400 transition-colors p-2"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>
