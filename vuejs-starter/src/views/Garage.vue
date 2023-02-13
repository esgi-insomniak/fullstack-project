<script setup>
import {onMounted, ref, watchEffect} from "vue";
import L from "leaflet";
import Map from "../components/Map.vue";
import GarageService from "../services/garage.service.js";
import UserService from "../services/user.service.js";
import CarService from "../services/car.service.js";
import GarageList from "../components/garage/GarageList.vue";
import CarList from "../components/garage/CarList.vue";
import RadioGroup from "../components/RadioGroup.vue";
import {useRoute} from "vue-router";
import GarageListWithMap from "../components/garage/GarageListWithMap.vue";

const route = useRoute();
const {identityId} = route.params;
const garageParams = (identityId) ? {
  "cars.identity.id": identityId,
  "itemsPerPage": 100,
  "order[isOpen]": "desc",
  "order[cars.identity.id]": "desc",
} : {
  "order[isOpen]": "desc",
  "itemsPerPage": 100,
};

const garages = ref([]);
const cars = ref([]);
const filteredCars = ref([]);
const me = ref({ address: "Votre position", coordinates: [46.635738928197114, 2.6308714120530854]});
const selectedCategory = ref(undefined);


const handleGarageIconClick = async (e) => {
  await getGarageCars(e.target.options.uniqueId);
};

const handleGarageClick = async (garage) => {
  await getGarageCars(garage.id)
};

const handleCarCategoryChange = (category) => {
  if (category === undefined) {
    filteredCars.value = cars.value;
  } else {
    filteredCars.value = cars.value.filter(car => car.identity.category.id === category);
  }
  selectedCategory.value = category;
};

const handleCarIdentityChange = (identity) => {
  if (identity === undefined) {
    handleCarCategoryChange(selectedCategory.value);
  } else {
    filteredCars.value = cars.value.filter(car => car.identity.id === identity);
  }
};

const getGarageCars = async (garageId) => {
  cars.value = await CarService.getGarageCars(garageId, { "isOrdered": false });
  filteredCars.value = cars.value;
  if (identityId) {
    const findCar = cars.value.find(car => car.identity.id == identityId);
    if (findCar && findCar.identity) {
      handleCarCategoryChange(findCar.identity.category.id);
      handleCarIdentityChange(findCar.identity.id);
    }
  }
};

const getCarCategory = (car) => {
  return {
    label: car.identity.category.name,
    id: car.identity.category.id,
  }
};

const getCarIdentity = (car) => {
  return {
    label: car.identity.name,
    id: car.identity.id,
  }
};

const getAllCarIdentities = (category) => {
  return cars.value.filter(car => car.identity.category.id === category).map(getCarIdentity).filter((v, i, a) => a.findIndex(t => (t.id === v.id)) === i);
};

const getAllCarCategories = () => {
  return cars.value.map(getCarCategory).filter((v, i, a) => a.findIndex(t => (t.id === v.id)) === i)
};

onMounted(async () => {
  // UserService.get("me").then((user) => {
  //   me.value = user;
  //   me.value.coordinates = me.value.coordinates.reverse();
  // })
  const filteredGarages = await GarageService.getCollection(garageParams);
  garages.value = Object.values(filteredGarages).filter(g => g.cars.filter(c => !c.isOrdered).length > 0);
});

</script>
<template>
  <div class="flex justify-center flex-col my-5" v-if="garages.length > 0">
    <GarageListWithMap
        :garages="garages"
        :handle-garage-click="handleGarageClick"
        :handle-garage-icon-click="handleGarageIconClick"
        :default-point="{
          name: me.address,
          coordinates: me.coordinates,
        }"
        search
    />
    <div class="p-6">
      <span class="h-1 w-full lg:w-1/3"></span>
      <div class="flex md:flex-row sm:flex-col" v-if="cars.length > 0">
        <div class="md:w-1/4 sm:w-full">
          <div class="mt-2">
            <h2 class="text-2xl font-bold">Catégories</h2>
            <RadioGroup class="uppercase" :selected="Number(selectedCategory)" :options="getAllCarCategories()" @on-selected="handleCarCategoryChange" />
          </div>

          <div class="mt-2" v-if="selectedCategory">
            <h2 class="text-2xl font-bold">Modèles</h2>
            <RadioGroup class="uppercase" :selected="Number(identityId)" :options="getAllCarIdentities(selectedCategory)" @on-selected="handleCarIdentityChange" />
          </div>
        </div>
        <div>
          <CarList :cars="filteredCars" :user="me"/>
        </div>
      </div>
    </div>

  </div>
</template>