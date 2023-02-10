<script setup>
import {
    ref,
    onMounted
} from 'vue';
import carService from "../../services/car.service";
import { UserPlusIcon, ChevronLeftIcon, ChevronRightIcon, TrashIcon, PencilSquareIcon, PlusCircleIcon } from '@heroicons/vue/24/outline';

const cars = ref([]);
const loading = ref(true);
const currentPage = ref(1);
const thead = [{
        id: 'id',
        label: 'ID'
    },
    {
        id: 'brand',
        label: 'Marque'
    },
    {
        id: 'model',
        label: 'Modèle'
    },
    {
        id: 'price',
        label: 'Prix'
    },
    {
        id: 'year',
        label: 'Année'
    },
    {
        id: 'fuel',
        label: 'Carburant'
    },
    {
        id: 'kilometers',
        label: 'Kilométrage'
    },
    {
        id: 'image',
        label: 'Image'
    },
    {
        id: 'actions',
        label: 'Actions'
    },
];

onMounted(async () => {
    cars.value = await carService.getCarCollection({
        page: currentPage.value
    });
    loading.value = false;
});

const deleteCar = async (id) => {
    await carService.deleteCar(id).then(response => {
        console.log(response);
    }).catch(error => {
        alert('La voiture ne peut être supprimer, elle est lié à une commande')
        console.log(error)
    })
};

const previousPage = async () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        await carService.getCarCollection({
            page: currentPage.value
        }).then(response => {
            cars.value = response;
            loading.value = false;
        }).catch(error => {
            console.log(error)
        })
    }
};

const nextPage = async () => {
    currentPage.value++;
    await carService.getCarCollection({
        page: currentPage.value
    }).then(response => {
        cars.value = response;
        loading.value = false;
        if (cars.value.length === 0) {
            previousPage();
        }
    }).catch(error => {
        console.log(error)
    })
};
</script>

<template>
<div class="h-[75vh] overflow-scroll scrollbar-hide">
    <div class="flex justify-between w-full">
    <h2 class="text-2xl uppercase tracking-widest">Voitures</h2>
    <button class="flex items-center justify-center min-w-[15rem]">Ajouter une voiture   <PlusCircleIcon class="w-5 h-5 ml-3" /></button>
    </div>
    <table class="table-auto w-full mx-auto text-left my-5">
        <tr>
            <th class="p-3" v-for="column in thead" :key="column.id">{{ column.label }}</th>
        </tr>
        <tr v-for="(car, index) in cars" :key="car.id" :class="{'bg-gray-400': index % 2 === 0, 'text-black': index % 2 === 0}">
            <td class="p-3">{{ car.id }}</td>
            <td class="py-3">BMW {{ car.identity.name }}</td>
            <td class="py-3">{{ car.identity.category.name }}</td>
            <td class="py-3">{{ car.price }}</td>
            <td class="py-3">{{ car.year }}</td>
            <td class="py-3">{{ car.fuel }}</td>
            <td class="py-3">{{ car.mileage }}</td>
            <td class="py-3">
                <img :src="car.images[0].src" width="150">
            </td>
            <td class="py-10 flex" :class="{'text-white': index % 2 === 0}">
                <button class="mr-3 flex items-center justify-center min-w-[8rem]">Modifier <PencilSquareIcon class="h-5 w-5 ml-3" /></button>
                <button @click="deleteCar(car.id)" class="ml-3 flex items-center justify-center min-w-[8rem]">Supprimer <TrashIcon class="h-5 w-5 ml-3" /></button>
            </td>
        </tr>
    </table>
</div>
<div class="flex justify-end my-5 space-x-3">
    <button @click="previousPage" class="bg-blue-900 min-w-[10rem]"><ChevronLeftIcon  class="h-7 w-7 mx-auto" /></button>
    <button @click="nextPage" class="bg-blue-900 min-w-[10rem]"><ChevronRightIcon  class="h-7 w-7 mx-auto" /></button>
</div>
</template>
