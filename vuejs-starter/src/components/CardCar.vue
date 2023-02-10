<script setup>
import { defineProps } from 'vue';
const props = defineProps({
    mainPicture: {
        String,
        required: true,
    },
    category: {
        Object,
        required: true,
    },
    name: {
        String,
        required: true,
    },
})

</script>
<template>
    <div class="w-full h-full flex flex-col items-center justify-start">
        <div class="w-80 h-56 flex items-center justify-center cursor-pointer">
            <img :src="mainPicture" class="w-full h-full object-cover bg-cover hover:scale-110 duration-150 ease-in-out" />
        </div>
        <div class="w-full h-12 flex items-center justify-center space-x-2">
            <span class="font-bold text-sm">{{ name }}</span>
            <span class="font-bold text-sm">{{ category.name }}</span>
        </div>
    </div>
</template>