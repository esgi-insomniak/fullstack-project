<script setup>
import { defineProps } from 'vue';
const props = defineProps({
    options: {
        type: Array,
        required: true,
    },
});
</script>
<template >
    <div class="w-full h-14 flex items-center justify-start">
        <div class="flex min-w-[3rem] h-full hover:underline decoration-blue-600 decoration-4 underline-offset-[1rem] cursor-pointer items-center justify-start"
            v-for="option in options">
            <span class="font-bold text-sm">{{ option.label }}</span>
        </div>
    </div>
</template>