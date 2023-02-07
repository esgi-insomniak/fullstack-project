<script setup>
import RadioGroup from '../components/RadioGroup.vue';
import Filter from '../components/Filter.vue';
import { onMounted, ref } from 'vue'
import CardCar from '../components/CardCar.vue';
import CarService from '../services/car.service.js';

const carCategories = ref([])
const allCars = ref([]);
const collapseInfo = ref({
    id: '',
    open: false
});
const filteredCars = ref([]);
const handleCollapseInfo = (carId) => {
    collapseInfo.value = {
        id: carId,
        open: !collapseInfo.value.open
    }
}
const getCarsByCategory = (category) => {
    if (category === undefined) filteredCars.value = allCars.value
    else filteredCars.value = allCars.value.filter(car => car.identity.category.id === category)
}
onMounted(async () => {
    allCars.value = await CarService.getCarCollection()
    carCategories.value = await CarService.getCarCategoryCollection()
    getCarsByCategory()
})
</script>
<template>
    <div class="w-full h-[88vh] px-52">
        <div class="relative h-2/6 w-full flex justify-center items-center ">
            <div class="w-full flex flex-col">
                <h1 class="tracking-[5px] uppercase text-xl mb-1">Trouver votre BMW</h1>
                <RadioGroup :options="carCategories" flex-direction="flex-row" position-flex="justify-start"
                    class="uppercase font-extrabold tracking-wider" @on-selected="getCarsByCategory" />
                <span class="mt-5">{{ allCars.length }} modèles trouvé: </span>
            </div>
        </div>
        <div class="grid grid-flow-dense grid-cols-3 gap-2">
            <template v-for="car in filteredCars">
                <CardCar :mainPicture="car.identity.mainPicture.src" :category="car.identity.category"
                    :name="car.identity.name" @click="handleCollapseInfo(car.slug)" />
                <div class="col-span-3 h-80 relative flex flex-col justify-center items-center mt-5"
                    v-show="collapseInfo.id === car.slug && collapseInfo.open === true">
                    <div class="w-1/2 h-1/2 flex justify-center">
                        <img :src="car.identity.mainPicture.src" :alt="car.identity.name" class="absolute -top-28">
                    </div>
                    <div class="rounded-md w-full h-full grid grid-flow-row grid-cols-3 gap-2 p-3">
                        <div class="flex flex-col space-y-2 justify-end bg-white/30 rounded-md h-full p-2">
                            <div class="flex space-x-2">
                                <span>{{ car.identity.category.id }}</span>
                                <span>BMW Serie {{ car.identity.name }}</span>
                            </div>
                            <button>En savoir plus</button>
                        </div>
                        <div class="flex flex-col space-y-2 justify-end bg-white/30 rounded-md h-full p-2">
                            <div class="flex space-x-2">
                                <span>Je commande ma BMW</span>
                            </div>
                            <button>Voir les stocks</button>
                        </div>
                        <div class="flex flex-col space-y-2 justify-end bg-white/30 rounded-md h-full p-2" />
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>