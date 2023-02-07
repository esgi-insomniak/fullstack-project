<script setup>
import GarageService from "../services/garage.service.js";
import {onMounted, ref} from "vue";
import Map from "../components/Map.vue";
import L from 'leaflet';
import UserService from "../services/user.service.js";

const garages = ref([]);
const me = ref(null);

const handleGarageIconClick = (e) => {
  const id = e.target.options.uniqueId;
  selectGarageById(id);
};

const handleGarageClick = (garage) => {
  selectGarageById(garage.id);
};

const selectGarageById = (id) => {
  garages.value.forEach(g => {
    g.selected = g.id === id;
  });
};

const scrollToSelectedGarage = (el) => {
  if (!el || !el instanceof HTMLElement) return;
  el.scrollIntoView({ behavior: 'smooth', block: 'center' });
};

onMounted(async () => {
  me.value = await UserService.get("me");
  me.value.coordinates = me.value.coordinates.reverse();
  garages.value = await GarageService.getCollection()
});

</script>
<template>
  <div class="grid grid-cols-2 gap-4">
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

      <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 max-h-[600px] overflow-auto scrollbar-hide">
        <li
            class="p-3 sm:p-4 hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer"
            v-for="garage in garages"
            :key="garage.id"
            :class="{'bg-gray-50 dark:bg-gray-800': garage.selected}"
            :data-selected="garage.selected"
            :ref="el => (garage.selected) ? scrollToSelectedGarage(el) : null"
            @click="selectGarageById(garage.id)"
        >
          <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
              <img class="w-8 h-8 rounded-full" src="/bmw_logo.png" :alt="garage.name">
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-900 truncate dark:text-white">{{ garage.name }}</p>
              <p class="text-sm text-gray-500 truncate dark:text-gray-400">email@flowbite.com</p>
            </div>
            <div
                class="inline-flex items-center text-base font-semibold"
                :class="{
                    'text-green-500': garage.isOpen,
                    'text-red-500': !garage.isOpen,
                }"
                v-text="garage.isOpen ? 'OUVERT' : 'FERMÉ'"
            >
            </div>
          </div>
        </li>
      </ul>



    </div>
  </div>
</template>