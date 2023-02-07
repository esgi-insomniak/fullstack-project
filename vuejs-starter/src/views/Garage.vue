<script setup>
import GarageService from "../services/garage.service.js";
import {onMounted, ref} from "vue";
import Map from "../components/Map.vue";
import L from 'leaflet';
import UserService from "../services/user.service.js";
import CarService from "../services/car.service.js";
import GarageList from "../components/garage/GarageList.vue";
import CarList from "../components/garage/CarList.vue";

const garages = ref([]);
const cars = ref([]);
const searchInput = ref(null);
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
};
const selectGarageById = (id) => {
  garages.value.forEach(g => {
    g.selected = g.id === id;
  });
};

onMounted(async () => {
  me.value = await UserService.get("me");
  me.value.coordinates = me.value.coordinates.reverse();
  garages.value = await GarageService.getCollection()
});

</script>
<template>
  <div class="container mx-auto my-5">

    <div class="flex flex-row" v-if="garages.length > 0">
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

    <div class="flex flex-row" v-if="cars.length > 0">
      <CarList :cars="cars" search/>
    </div>

  </div>
</template>