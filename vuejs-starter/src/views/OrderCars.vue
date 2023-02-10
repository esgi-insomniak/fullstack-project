<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import CarService from '../services/car.service.js';
import Cars from '../components/Cars.vue';
import GarageService from '../services/garage.service.js';
import UserService from '../services/user.service.js';
import GarageList from "../components/garage/GarageList.vue";

const $route = useRoute();
const carsSelected = ref([]);
const garages = ref([]);
const me = ref(null);
const id = $route.params.id;

const onSelectGarage = async (garage) => {
    carsSelected.value = await CarService.getGarageCars(garage.id, {
        "identity.id": id,
    });
}

onMounted(async () => {
    me.value = await UserService.get("me");
    me.value.coordinates = me.value.coordinates.reverse();
    garages.value = await GarageService.getCollection({
        "cars.identity.id": id,
        "itemsPerPage": 50,
        "order[isOpen]": "desc",
        "order[cars.identity.id]": "desc",
    })
    if (garages.value.length > 0) {
        carsSelected.value = await CarService.getGarageCars(garages.value[0].id, {
            "identity.id": id,
        });
    }
});
</script>
<template>
    <div class="h-[88vh] w-full flex">
        <div class="flex w-1/2 h-full flex-col py-5 pl-5">
            <div class="h-full w-full overflow-scroll scrollbar-hide" v-if="garages.length > 0">
                <GarageList :garages="garages" @garage-click="onSelectGarage" search />
            </div>
        </div>
        <div class="flex w-1/2 h-full flex-col space-y-3 p-5 overflow-scroll scrollbar-hide">
            <div v-if="carsSelected.length > 0" class="text-2xl font-bold text-gray-900 dark:text-white">Garage {{
                carsSelected[0].garage.name
            }}</div>
            <template v-for="car in carsSelected">
                <Cars :car="car" :isFavorite="false" />
            </template>
        </div>
    </div>
</template>