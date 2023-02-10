<script setup>
import {onMounted, ref} from "vue";
import L from "leaflet";
import Map from "../components/Map.vue";
import GarageService from "../services/garage.service.js";
import UserService from "../services/user.service.js";
import CarService from "../services/car.service.js";
import GarageList from "../components/garage/GarageList.vue";
import CarList from "../components/garage/CarList.vue";
import RadioGroup from "../components/RadioGroup.vue";
import {useRoute} from "vue-router";

const route = useRoute();
const {identityId} = route.params;
const garageParams = (identityId) ? {
  "cars.identity.id": identityId,
  "itemsPerPage": 50,
  "order[isOpen]": "desc",
  "order[cars.identity.id]": "desc",
} : {};

const garages = ref([]);
const cars = ref([]);
const filteredCars = ref([]);
const me = ref(null);



const handleGarageIconClick = async (e) => {
  await getGarageCars(e.target.options.uniqueId);
};

const handleGarageClick = async (garage) => {
  await getGarageCars(garage.id)
};

const getGarageCars = async (garageId) => {
  selectGarageById(garageId);
  cars.value = await CarService.getGarageCars(garageId);
  filteredCars.value = cars.value;
};

const getCarCategory = (car) => {
  return {
    label: car.identity.category.name,
    id: car.identity.category.id,
  }
};

const getAllCarCategories = () => {
  return cars.value.map(getCarCategory).filter((v, i, a) => a.findIndex(t => (t.id === v.id)) === i)
};

const handleCarCategoryChange = (category) => {
  if (category === undefined) {
    filteredCars.value = cars.value;
  } else {
    filteredCars.value = cars.value.filter(car => car.identity.category.id === category);
  }
};

const selectGarageById = (id) => {
  garages.value.forEach(g => {
    g.selected = g.id === id;
  });
};

onMounted(async () => {
  me.value = await UserService.get("me");
  me.value.coordinates = me.value.coordinates.reverse();
  console.log(garageParams);
  garages.value = await GarageService.getCollection(garageParams)
});

</script>
<template>
  <div class="flex justify-center flex-col my-5">
    <div class="flex flex-row justify-center" v-if="garages.length > 0">
      <Map
          :zoom="8"
          :icon-to-display="new L.icon({
            iconUrl: '/src/assets/bmw_logo.png',
            iconSize: [35, 35],
            iconAnchor: [13, 41],
            popupAnchor: [0, -41],
          })"
          :points-to-display="garages.map(garage => {
            return {
              name: garage.name,
              coordinates: garage.coordinates,
              uniqueId: garage.id,
              onClick: handleGarageIconClick
            }
          })"
          :default-point="{
            name: me.address,
            coordinates: me.coordinates
          }"
      />
      <GarageList :garages="garages" @garage-click="handleGarageClick" search/>
    </div>

    <div class="p-6">
      <span class="h-1 w-full lg:w-1/3"></span>
      <div class="flex md:flex-row sm:flex-col" v-if="cars.length > 0">
        <div class="md:w-1/4 mt-2 sm:w-full">
          <h2 class="text-2xl font-bold">Catégories</h2>
          <RadioGroup class="uppercase" :options="getAllCarCategories()" @on-selected="handleCarCategoryChange" />
        </div>
        <div>
          <CarList :cars="filteredCars" search/>
        </div>
      </div>
    </div>

  </div>
</template>