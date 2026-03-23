<template>
    <div class="juvi-card p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Vista Previa</h2>
        
        <div v-if="filePreview" class="space-y-4">
            <div class="relative rounded-lg overflow-hidden bg-gray-900">
                <img 
                    v-if="isImage" 
                    :src="filePreview" 
                    class="w-full h-48 object-contain"
                    alt="Preview"
                />
                <video 
                    v-else 
                    :src="filePreview" 
                    class="w-full h-48 object-contain"
                    controls
                ></video>
            </div>
            
            <div v-if="caption" class="text-gray-300 text-sm whitespace-pre-wrap">{{ caption }}</div>
        </div>
        
        <div v-else class="text-center py-8 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
            <p class="text-sm">Sube un archivo para ver la preview</p>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    file: File,
    filePreview: String,
    caption: String
});

const isImage = computed(() => props.file?.type?.startsWith('image/') || false);
</script>
