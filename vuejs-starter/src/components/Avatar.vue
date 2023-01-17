<script setup>
import { defineProps } from 'vue';
import { getInitials } from '../helpers';
const props = defineProps({
    name: {
        type: String,
        required: true
    },
    color: {
        type: Object,
        required: false,
        default: {
            background: 'bg-white/20',
            text: 'text-white'
        }
    }
})
</script>
<template>
    <div :class="color.background" class="flex justify-center items-center h-20 w-20 shadow rounded-full">
        <span :class="color.text" class="flex text-center justify-center font-bold text-2xl">
            {{ getInitials(name) }}
        </span>
    </div>
</template>