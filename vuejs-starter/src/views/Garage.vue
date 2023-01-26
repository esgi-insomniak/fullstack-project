<!-- <script setup>
import L from 'leaflet'
import { onMounted } from 'vue'

const accessToken = import.meta.env.VITE_API_JAWG_ACCESS_TOKEN
const bmwShops = [
    {
        id: 1,
        name: 'BMW Shop 1',
        address: '123 Main St',
        latitude: 37.7749,
        longitude: -122.4194
    },
    {
        id: 2,
        name: 'BMW Shop 2',
        address: '456 Market St',
        latitude: 37.7902,
        longitude: -122.4018
    }
]
onMounted(() => {
    // Create the map and set the view to the first BMW shop
    map = L.map('mapContainer').setView([bmwShops[0].latitude, bmwShops[0].longitude], 13)

    // Add the Jawg Maps tile layer to the map
    L.tileLayer(`https://{s}.tile.jawg.io/{style}/{z}/{x}/{y}{r}.png?access-token=${accessToken}`, {
        style: 'streets',
        attribution: '<a href="https://www.jawg.io" target="_blank">&copy; Jawg</a>',
        subdomains: 'abcd',
        minZoom: 0,
        maxZoom: 22,
        ext: 'jpg'
    }).addTo(map)

    // Add a marker for each BMW shop
    bmwShops.forEach(shop => {
        L.marker([shop.latitude, shop.longitude]).addTo(map)
    })
})

</script>

<template>
    <div class="w-full h-screen overflow-auto">
        <div ref="mapContainer" class="w-full h-full" />
    </div>
</template>
 -->

<script setup>
import GarageService from "../services/garage.service.js";
import {onMounted, ref, defineAsyncComponent, onBeforeMount} from "vue";
import Map from "../components/Map.vue";
import L from 'leaflet';

//const MapLoader = defineAsyncComponent(() => import("../components/Map.vue"));
const garages = ref([]);

onBeforeMount(async () => {
  garages.value = await GarageService.getCollection()
});

const nextGarages = ({type, geometry, properties, bbox}) => {
  const coordinates = geometry.coordinates;
};

</script>
<template>
  <Map
      v-if="garages.length > 0"
      :zoom="11"
      :icon-to-display="new L.icon({
        iconUrl: '/src/assets/bmw_logo.png',
        iconSize: [35, 35],
        iconAnchor: [13, 41],
        popupAnchor: [0, -41]
      })"
      :points-to-display="garages.map(garage => {
    return {
      name: garage.name,
      coordinates: [garage.coordinates[0], garage.coordinates[1]],
    }
  })" />
</template>