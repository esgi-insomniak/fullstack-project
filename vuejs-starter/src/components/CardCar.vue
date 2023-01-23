<script setup>
import { ref, defineProps } from 'vue';
const props = defineProps({
    mainPicture: {
        Object,
        required: true,
    },
    category: {
        Object,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
})
const collapseInfo = ref(false);
const handleCollapseInfo = () => {
    collapseInfo.value = !collapseInfo.value;
}
</script>
<template>
    <div class="w-full h-full flex flex-col items-center justify-start">
        <div class="w-80 h-56 flex items-center justify-center" @click="handleCollapseInfo">
            <img :src="mainPicture.src"
                class="w-full h-full object-cover bg-cover hover:scale-110 duration-150 ease-in-out" />
        </div>
        <div class="w-full h-12 flex items-center justify-center space-x-2">
            <span class="font-bold text-sm">{{ name }}</span>
            <span class="font-bold text-sm">{{ category.name }}</span>
        </div>
        <div v-show="!!collapseInfo" class="h-64 w-full bg-white">
            Je suis l'info
        </div>

    </div>
</template>