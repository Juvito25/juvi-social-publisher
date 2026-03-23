<template>
    <div class="min-h-screen p-6">
        <div class="max-w-7xl mx-auto">
            <header class="mb-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 juvi-gradient rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-juvi-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Juvi Social Publisher</h1>
                        <p class="text-gray-400 text-sm">Publica en todas tus redes desde un solo lugar</p>
                    </div>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <FileUploader 
                        v-model="file" 
                        :preview="filePreview"
                        @update:preview="filePreview = $event"
                    />

                    <PostForm 
                        v-model:caption="caption"
                        v-model:hashtags="hashtags"
                    />

                    <SocialSelector 
                        v-model="selectedNetworks"
                        :disabled="!file"
                    />
                </div>

                <div class="space-y-6">
                    <PreviewCard 
                        :file="file"
                        :file-preview="filePreview"
                        :caption="fullCaption"
                    />

                    <div class="juvi-card p-6">
                        <button 
                            @click="publish" 
                            :disabled="!canPublish || publishing"
                            class="juvi-btn w-full flex items-center justify-center gap-2"
                        >
                            <svg v-if="publishing" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            {{ publishing ? 'Publicando...' : 'Publicar en Todas' }}
                        </button>

                        <p v-if="!canPublish && file" class="text-gray-500 text-sm mt-3 text-center">
                            Selecciona al menos una red social
                        </p>
                        <p v-if="!file" class="text-gray-500 text-sm mt-3 text-center">
                            Sube un archivo para continuar
                        </p>
                    </div>

                    <HistoryList :posts="posts" @delete="deletePost" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import FileUploader from './Components/FileUploader.vue';
import PostForm from './Components/PostForm.vue';
import SocialSelector from './Components/SocialSelector.vue';
import PreviewCard from './Components/PreviewCard.vue';
import HistoryList from './Components/HistoryList.vue';

const file = ref(null);
const filePreview = ref(null);
const caption = ref('');
const hashtags = ref('');
const selectedNetworks = ref([]);
const posts = ref([]);
const publishing = ref(false);

const fullCaption = computed(() => {
    let text = caption.value;
    if (hashtags.value) {
        text += '\n\n' + hashtags.value;
    }
    return text;
});

const canPublish = computed(() => {
    return file.value && selectedNetworks.value.length > 0;
});

const publish = async () => {
    if (!canPublish.value || publishing.value) return;

    publishing.value = true;
    
    try {
        const formData = new FormData();
        formData.append('file', file.value);
        formData.append('caption', caption.value);
        formData.append('hashtags', JSON.stringify(hashtags.value.split(' ').filter(h => h)));
        formData.append('selected_networks', JSON.stringify(selectedNetworks.value));

        const response = await axios.post('/api/posts', formData);
        const post = response.data;

        const shareUrls = {
            instagram: 'https://www.instagram.com/',
            tiktok: 'https://www.tiktok.com/upload',
            facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(window.location.origin + '/storage/' + post.file_path)}`,
            whatsapp: `https://wa.me/?text=${encodeURIComponent(fullCaption.value)}`
        };

        for (const network of selectedNetworks.value) {
            const url = shareUrls[network];
            if (url) {
                window.open(url, '_blank', 'width=800,height=600');
            }
        }

        await axios.put(`/api/posts/${post.id}`, { status: 'shared' });
        await fetchPosts();

        file.value = null;
        filePreview.value = null;
        caption.value = '';
        hashtags.value = '';
        selectedNetworks.value = [];

    } catch (error) {
        console.error('Error al publicar:', error);
        alert('Error al publicar. Ver consola para detalles.');
    } finally {
        publishing.value = false;
    }
};

const fetchPosts = async () => {
    try {
        const response = await axios.get('/api/posts');
        posts.value = response.data;
    } catch (error) {
        console.error('Error al cargar posts:', error);
    }
};

const deletePost = async (id) => {
    try {
        await axios.delete(`/api/posts/${id}`);
        await fetchPosts();
    } catch (error) {
        console.error('Error al eliminar post:', error);
    }
};

onMounted(() => {
    fetchPosts();
});
</script>
