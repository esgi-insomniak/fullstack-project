<script setup>
import RadioGroup from '../components/RadioGroup.vue';
import Filter from '../components/Filter.vue';
import { ref } from 'vue'
import CardCar from '../components/CardCar.vue';
const carCategories = ref([
    { label: 'Berline', slug: 'berline', id: 1 },
    { label: 'Break', slug: 'break', id: 2 },
    { label: 'Coupé', slug: 'coupe', id: 3 },
    { label: 'Cabriolet', slug: 'cabriolet', id: 4 },
    { label: '4x4', slug: '4x4', id: 5 },
    { label: 'Monospace', slug: 'monospace', id: 6 },
    { label: 'Utilitaire', slug: 'utilitaire', id: 7 }
])
const carModel = ref([
    { label: '1', href: '#', id: 1 },
    { label: '2', href: '#', id: 2 },
    { label: '3', href: '#', id: 3 },
    { label: 'x1', href: '#', id: 4 },
    { label: 'x2', href: '#', id: 5 },
    { label: 'x3', href: '#', id: 6 },
    { label: 'm1', href: '#', id: 7 },
    { label: 'm2', href: '#', id: 8 },
    { label: 'm3', href: '#', id: 9 },
    { label: 'z1', href: '#', id: 10 }
])
const collapseInfo = ref(false);
const handleCollapseInfo = () => {
    collapseInfo.value = !collapseInfo.value;
}
</script>
<template>
    <div class="w-full h-[88vh] px-52">
        <div class="relative h-2/6 w-full flex justify-center items-center ">
            <div class="w-full flex flex-col">
                <h1 class="tracking-[5px] uppercase text-xl mb-1">Trouver votre BMW</h1>
                <RadioGroup :options="carCategories" flex-direction="flex-row" position-flex="justify-start" />
                <span class="mt-5">{{ carModel.length }} modèles trouvé: </span>
                <div class="">
                    <Filter :options="carModel" />
                </div>
            </div>
        </div>
        <div class="grid grid-flow-dense grid-cols-3 gap-2">
            <CardCar name="BMW 1" :category="{ name: 'Berline' }" :main-picture="{ src: 'src/assets/bmw_serie_1.png' }"
                @click="handleCollapseInfo" />
            <div class="col-span-3 h-80 relative flex flex-col justify-center items-center mt-5"
                v-show="!!collapseInfo">
                <div class="w-1/2 h-1/2 flex justify-center">
                    <img src="src/assets/bmw_serie_1.png" alt="" class="absolute -top-28">
                </div>
                <div class="rounded-md w-full h-full grid grid-flow-row grid-cols-3 gap-2 p-3">
                    <div class="flex flex-col space-y-2 justify-end bg-white/30 rounded-md h-full p-2">
                        <div class="flex space-x-2">
                            <span>{{ carCategories[0].label }}</span>
                            <span>BMW Serie {{ carModel[0].label }}</span>
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
            <CardCar name="BMW 1" :category="{ name: 'Berline' }"
                :main-picture="{ src: 'src/assets/bmw_serie_1.png' }" />
            <CardCar name="BMW 1" :category="{ name: 'Berline' }"
                :main-picture="{ src: 'src/assets/bmw_serie_1.png' }" />
            <CardCar name="BMW 1" :category="{ name: 'Berline' }"
                :main-picture="{ src: 'src/assets/bmw_serie_1.png' }" />
            <CardCar name="BMW 1" :category="{ name: 'Berline' }"
                :main-picture="{ src: 'src/assets/bmw_serie_1.png' }" />
        </div>
    </div>
</template>