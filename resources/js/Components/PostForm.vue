<template>
    <div class="juvi-card p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Contenido</h2>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm text-gray-400 mb-2">Caption</label>
                <textarea
                    :value="caption"
                    @update:modelValue="$emit('update:caption', $event)"
                    class="juvi-input min-h-[120px] resize-none"
                    placeholder="Escribe tu caption..."
                    maxlength="2200"
                ></textarea>
                <p class="text-xs text-gray-500 mt-1 text-right">{{ caption.length }}/2200</p>
            </div>
            
            <div>
                <label class="block text-sm text-gray-400 mb-2">Hashtags</label>
                <input
                    type="text"
                    :value="hashtags"
                    @update:modelValue="$emit('update:hashtags', $event)"
                    class="juvi-input"
                    placeholder="#marketing #socialmedia #juviweb"
                />
                <p class="text-xs text-gray-500 mt-1">Separa los hashtags con espacios</p>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    caption: String,
    hashtags: String
});

defineEmits(['update:caption', 'update:hashtags']);
</script>
