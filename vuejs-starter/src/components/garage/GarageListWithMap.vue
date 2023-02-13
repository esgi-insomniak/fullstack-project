<script setup>
import GarageList from "./GarageList.vue";
import Map from "../Map.vue";
import L from "leaflet";
import { ref } from "vue";

const props = defineProps({
  garages: {
    type: Array,
    required: true,
  },
  search: {
    type: Boolean,
    default: false,
  },
  handleGarageIconClick: {
    type: Function,
    required: false,
  },
  handleGarageClick: {
    type: Function,
    required: false,
  },
  defaultPoint: {
    type: Object,
    required: false,
  },
});
const garagesList = ref(props.garages);
const selectGarageById = (id) => {
  garagesList.value.forEach(g => {
    g.selected = g.id === id;
  });
};

const handleGarageIconClick = (e) => {
  if (typeof props.handleGarageIconClick === "function") {
    props.handleGarageIconClick(e);
  }
  selectGarageById(e.target.options.uniqueId);
};

const handleGarageClick = (garage) => {
  if (typeof props.handleGarageClick === "function") {
    props.handleGarageClick(garage);
  }
  selectGarageById(garage.id);
};

</script>

<template>
  <div class="flex flex-row justify-center">
    <Map :zoom="8" :icon-to-display="new L.icon({
      iconUrl: '/src/assets/bmw_logo.png',
      iconSize: [35, 35],
      iconAnchor: [13, 41],
      popupAnchor: [0, -41],
    })" :points-to-display="garagesList.map(garage => {
  return {
    name: garage.name,
    coordinates: garage.coordinates,
    uniqueId: garage.id,
    onClick: handleGarageIconClick
  }
})" :default-point="defaultPoint" />
    <GarageList :garages="garagesList" @garage-click="handleGarageClick" search />
  </div>
</template>

<style scoped>

</style>