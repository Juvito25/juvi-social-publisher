<template>
    <div class="juvi-card p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Redes Sociales</h2>
        
        <div class="grid grid-cols-2 gap-3">
            <label 
                v-for="network in networks" 
                :key="network.id"
                class="flex items-center gap-3 p-3 rounded-lg border border-juvi-border cursor-pointer transition-all"
                :class="{ 
                    'bg-juvi-primary/10 border-juvi-primary': modelValue.includes(network.id),
                    'hover:border-juvi-primary/50': !disabled 
                }"
            >
                <input 
                    type="checkbox"
                    :value="network.id"
                    :checked="modelValue.includes(network.id)"
                    :disabled="disabled"
                    @change="toggleNetwork(network.id)"
                    class="social-checkbox"
                />
                <div class="flex items-center gap-2">
                    <component :is="network.icon" class="w-5 h-5" />
                    <span class="text-white">{{ network.name }}</span>
                </div>
            </label>
        </div>

        <div v-if="modelValue.length > 0" class="mt-4 pt-4 border-t border-juvi-border">
            <p class="text-sm text-gray-400">
                Seleccionadas: <span class="text-juvi-primary font-medium">{{ modelValue.length }}</span>
            </p>
        </div>
    </div>
</template>

<script setup>
import { h } from 'vue';

defineProps({
    modelValue: {
        type: Array,
        default: () => []
    },
    disabled: Boolean
});

const emit = defineEmits(['update:modelValue']);

const InstagramIcon = {
    render() {
        return h('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', fill: 'currentColor', class: 'w-5 h-5 text-pink-500' }, [
            h('path', { d: 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z' })
        ]);
    }
};

const TikTokIcon = {
    render() {
        return h('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', fill: 'currentColor', class: 'w-5 h-5 text-black' }, [
            h('path', { d: 'M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93v6.16c0 2.52-1.12 4.84-2.64 6.46-1.54 1.62-3.53 2.77-5.67 2.99-2.71.29-5.28-.84-6.56-2.87-1.27-2.04-1.45-4.75-.46-6.95 1.08-2.28 3.22-3.88 5.6-4.31.63-.11 1.27-.17 1.9-.25-.09-.63-.12-1.29-.1-1.95.06-1.98 1.69-3.54 3.66-3.65 1.74-.1 3.42.5 4.44 1.99.87 1.27 1.01 3 .26 4.27-.87 1.25-2.24 1.89-3.65 1.89-1.08-.01-2.09-.48-2.65-1.2-.55-.71-.67-1.62-.31-2.44l.02-.03z' })
        ]);
    }
};

const FacebookIcon = {
    render() {
        return h('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', fill: 'currentColor', class: 'w-5 h-5 text-blue-600' }, [
            h('path', { d: 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z' })
        ]);
    }
};

const WhatsAppIcon = {
    render() {
        return h('svg', { xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', fill: 'currentColor', class: 'w-5 h-5 text-green-500' }, [
            h('path', { d: 'M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z' })
        ]);
    }
};

const networks = [
    { id: 'instagram', name: 'Instagram', icon: InstagramIcon },
    { id: 'tiktok', name: 'TikTok', icon: TikTokIcon },
    { id: 'facebook', name: 'Facebook', icon: FacebookIcon },
    { id: 'whatsapp', name: 'WhatsApp', icon: WhatsAppIcon },
];

const toggleNetwork = (id) => {
    const current = [...modelValue.value];
    const index = current.indexOf(id);
    if (index === -1) {
        current.push(id);
    } else {
        current.splice(index, 1);
    }
    emit('update:modelValue', current);
};
</script>
