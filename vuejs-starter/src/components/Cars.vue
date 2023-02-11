<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    car: {
        type: Object,
        required: true
    },
    isFavorite: {
        type: Boolean,
        required: true
    },
    actionFavorite: {
        type: Function,
        required: true
    }
});
</script>
<template>
    <div
        class="bg-white/20 hover:bg-white/10 hover:shadow-white/90 w-full h-64 rounded-xl flex shadow-inner shadow-white/60 p-4">
        <div class="w-1/3 h-full object-cover items-center flex justify-center relative">
            <img :src="car.mainImage" alt="" class="object-cover absolute top-3">
        </div>
        <div class="flex flex-col divide-y w-full">
            <div class="flex flex-col ">
                <h2 class="text-2xl">{{ car.name }} - {{ car.model }}</h2>
                <span>Prix: {{ car.price }}€</span>
            </div>
            <div class="grid grid-flow-row grid-cols-3 mt-3 gap-5">
                <span class="italic">{{ car.date }}</span>
                <span class="italic">{{ car.km }} km</span>
                <span class="italic">{{ car.gearbox }}</span>
                <span class="italic">{{ car.fuel }}</span>
                <span class="italic">{{ car.location }}</span>
                <span class="italic">{{ car.consumption }}</span>
                <span class="italic">{{ car.doors }} portes</span>
                <span class="italic">{{ car.power }}ch</span>
            </div>
        </div>
    </div>
</template>