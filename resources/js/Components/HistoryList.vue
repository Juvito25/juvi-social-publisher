<template>
    <div class="juvi-card p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Historial</h2>
        
        <div v-if="posts.length > 0" class="space-y-3">
            <div 
                v-for="post in posts" 
                :key="post.id"
                class="flex items-center justify-between p-3 bg-gray-800/50 rounded-lg"
            >
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="w-10 h-10 rounded bg-gray-700 flex items-center justify-center flex-shrink-0">
                        <svg v-if="post.file_type === 'image'" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm truncate">{{ post.caption || 'Sin caption' }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span :class="getStatusClass(post.status)" class="status-badge">
                                {{ getStatusLabel(post.status) }}
                            </span>
                            <span class="text-gray-500 text-xs">
                                {{ formatDate(post.created_at) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <button 
                    @click="$emit('delete', post.id)"
                    class="p-2 text-gray-500 hover:text-red-400 transition-colors"
                    title="Eliminar"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        </div>
        
        <div v-else class="text-center py-6 text-gray-500">
            <p class="text-sm">No hay publicaciones aún</p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    posts: {
        type: Array,
        default: () => []
    }
});

defineEmits(['delete']);

const getStatusClass = (status) => {
    const classes = {
        'pending': 'status-pending',
        'shared': 'status-shared',
        'failed': 'status-failed'
    };
    return classes[status] || '';
};

const getStatusLabel = (status) => {
    const labels = {
        'pending': 'Pendiente',
        'shared': 'Publicado',
        'failed': 'Error'
    };
    return labels[status] || status;
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-AR', {
        day: '2-digit',
        month: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>
