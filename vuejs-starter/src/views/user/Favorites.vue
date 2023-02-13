<script setup>
import { reactive } from 'vue';
import SkeletonFavorites from '../../components/Skeleton/SkeletonFavorites.vue'
import Cars from '../../components/Cars.vue';
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

</script>

<template>
    <div class="w-full h-screen py-5 px-52 space-y-5">
        <h1 class="text-2xl underline">Mes annonces préférées</h1>
        <div class="h-[80vh] space-y-5 overflow-scroll">
            <template v-for="car in cars">
                <div>
                    <router-link class="bg-white/20 w-full h-fit rounded-xl" to="/model/car">
                        <!--:to="{ name: 'model', params: { id: car.id } }"-->
                        <Cars :car="car" :isFavorite="true" />
                    </router-link>
                </div>
            </template>
        </div>
    </div>
</template>