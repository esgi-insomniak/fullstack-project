<script setup>
import { reactive } from 'vue';
import SkeletonFavorites from '../../components/Skeleton/SkeletonFavorites.vue'
const cars = reactive([
    {
        id: 1,
        name: 'BMW Serie 1 - 2022',
        price: 35000,
        km: 9686,
        power: 109,
        date: '05/2022',
        type: 'Occasion',
        gearbox: 'Boîte Manuelle',
        fuel: 'Essence',
        location: 'Charleroi - Louyet',
        consumption: '5.4l/100km',
        doors: 5,
        image: "/bmw_series_1.png"
    },
])

</script>

<template>
    <div class="w-full h-screen py-5 px-52 space-y-5">
        <h1 class="text-2xl underline">Mes annonces préférées</h1>
        <div class="h-[80vh] space-y-5 overflow-scroll">
            <template v-for="car in cars">
                <div>
                    <router-link class="bg-white/20 w-full h-fit rounded-xl" to="/model/car">
                        <!--:to="{ name: 'model', params: { id: car.id } }"-->
                        <div class="bg-white/20 w-full h-64 rounded-xl flex shadow-inner shadow-white/60 p-4">
                            <div class="w-1/3 h-full object-cover items-center flex justify-center relative">
                                <img src="../../assets/bmw_serie_1.png" alt="" class="object-cover absolute top-3">
                            </div>
                            <div class="flex flex-col divide-y w-full">
                                <div class="flex flex-col ">
                                    <h2 class="text-2xl">{{ car.name }}</h2>
                                    <span>Prix: {{ car.price }}€</span>
                                </div>
                                <div class="grid grid-flow-row grid-cols-3 mt-3 gap-5">
                                    <span class="italic">{{ car.date }}</span>
                                    <span class="italic">{{ car.type }}</span>
                                    <span class="italic">{{ car.gearbox }}</span>
                                    <span class="italic">{{ car.fuel }}</span>
                                    <span class="italic">{{ car.location }}</span>
                                    <span class="italic">{{ car.consumption }}</span>
                                    <span class="italic">{{ car.doors }} portes</span>
                                    <span class="italic">{{ car.power }}ch</span>
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>
            </template>
        </div>
    </div>
</template>