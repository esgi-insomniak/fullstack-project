<script setup>
import { reactive } from 'vue';
const cars = reactive([
    {
        id: 'ERQSDF43T6HH75',
        name: 'BMW Serie 1',
        model: '116i',
        price: 35000,
        km: 9686,
        power: 109,
        date: '05/2022',
        gearbox: 'Boîte Manuelle',
        fuel: 'Essence',
        location: 'Charleroi - Louyet',
        consumption: '5.4l/100km',
        doors: 5,
        image: "/bmw_series_1.png"
    },
])
const progress = reactive([
    {
        id: 'ERQSDF43T6HH75',
        order: true,
        payement: true,
        technical_inspection: true,
        delivery: false,
        reception: false,
    },
])
</script>
<template>
    <div class="w-5/6 h-52 rounded-lg bg-white/20 flex shadow-inner shadow-slate-200">
        <div class="relative w-1/5 h-full">
            <div
                class="absolute -left-32 -top-5 h-52 w-96 hover:scale-110 duration-300 ease-in-out bg-[url('/public/bmw_serie_1.png')] bg-cover" />
        </div>
        <template v-for="car in cars">
            <div class="relative w-2/3 py-5 flex flex-col space-y-5 ml-10 item-start">
                <div class="flex flex-col">
                    <span>{{ car.name }} - {{ car.model }}</span>
                    <span>{{ car.date }}</span>
                    <span>Chasis: {{ car.id }}</span>
                </div>
                <div class="flex max-w-xl w-full justify-between text-left">
                    <span class="min-w-[3rem]">Order</span>
                    <span class="min-w-[3rem]">Payement</span>
                    <span class="min-w-[3rem]">Technical inspection</span>
                    <span class="min-w-[3rem]">Delivery underway</span>
                    <span class="min-w-[3rem]">Delivered</span>
                </div>
                <div>
                    <div class="w-full max-w-xl h-2 bg-white/20 shadow-md rounded-full">
                        <div class="w-3/5 h-full bg-blue-500/60 shadow-inner shadow-blue-300 rounded-full" />
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>