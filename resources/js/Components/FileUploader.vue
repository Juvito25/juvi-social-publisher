<template>
    <div class="juvi-card p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Subir Archivo</h2>
        
        <div 
            class="drop-zone"
            :class="{ 'drag-over': isDragOver }"
            @dragover.prevent="isDragOver = true"
            @dragleave.prevent="isDragOver = false"
            @drop.prevent="handleDrop"
            @click="triggerFileInput"
        >
            <input 
                ref="fileInput"
                type="file"
                class="hidden"
                :accept="acceptedTypes"
                @change="handleFileSelect"
            />
            
            <div v-if="!preview" class="flex flex-col items-center gap-3 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <div>
                    <p class="font-medium">Arrastra tu archivo aquí</p>
                    <p class="text-sm">o haz clic para seleccionar</p>
                </div>
                <p class="text-xs text-gray-500">JPG, PNG, GIF, MP4, MOV (máx 100MB)</p>
            </div>
            
            <div v-else class="flex flex-col items-center gap-3">
                <img 
                    v-if="isImage" 
                    :src="preview" 
                    class="max-h-48 rounded-lg object-contain"
                    alt="Preview"
                />
                <video 
                    v-else 
                    :src="preview" 
                    class="max-h-48 rounded-lg object-contain"
                    controls
                ></video>
                <p class="text-sm text-gray-400">{{ fileName }}</p>
            </div>
        </div>
        
        <div v-if="error" class="mt-3 text-red-400 text-sm">
            {{ error }}
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';

const props = defineProps({
    modelValue: File,
    preview: String
});

const emit = defineEmits(['update:modelValue', 'update:preview']);

const fileInput = ref(null);
const isDragOver = ref(false);
const error = ref('');

const fileName = computed(() => props.modelValue?.name || '');
const isImage = computed(() => props.modelValue?.type?.startsWith('image/') || false);
const acceptedTypes = 'image/*,video/mp4,video/quicktime,video/x-msvideo';

const triggerFileInput = () => {
    fileInput.value?.click();
};

const validateFile = (file) => {
    error.value = '';
    
    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    const validVideoTypes = ['video/mp4', 'video/quicktime', 'video/x-msvideo'];
    
    const isValidImage = validImageTypes.includes(file.type);
    const isValidVideo = validVideoTypes.includes(file.type);
    
    if (!isValidImage && !isValidVideo) {
        error.value = 'Tipo de archivo no válido. Usa JPG, PNG, GIF o MP4.';
        return false;
    }
    
    if (file.size > 100 * 1024 * 1024) {
        error.value = 'El archivo excede el límite de 100MB.';
        return false;
    }
    
    return true;
};

const handleFile = (file) => {
    if (!validateFile(file)) return;
    
    emit('update:modelValue', file);
    
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            emit('update:preview', e.target.result);
        };
        reader.readAsDataURL(file);
    } else {
        const reader = new FileReader();
        reader.onload = (e) => {
            emit('update:preview', e.target.result);
        };
        reader.readAsDataURL(file);
    }
};

const handleFileSelect = (event) => {
    const file = event.target.files[0];
    if (file) handleFile(file);
};

const handleDrop = (event) => {
    isDragOver.value = false;
    const file = event.dataTransfer.files[0];
    if (file) handleFile(file);
};
</script>
