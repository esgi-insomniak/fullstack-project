<script setup>
import {onMounted, ref} from "vue";
import GarageService from "../../services/garage.service.js";
import UserService from "../../services/user.service.js";
import CarService from "../../services/car.service.js";
import L from "leaflet";
import GarageList from "../../components/garage/GarageList.vue";
import Vue3EasyDataTable from 'vue3-easy-data-table';
import RadioGroup from "../../components/RadioGroup.vue";
import CarList from "../../components/garage/CarList.vue";
import GarageListWithMap from "../../components/garage/GarageListWithMap.vue";


const garages = ref([]);
const orders = ref([]);
const cars = ref([]);

const radioOptions = [
  {label: 'Commandes', id: 'orders'},
  {label: 'Voitures', id: 'cars'}
];
const orderHeaders = [
  {text: 'ID', value: 'id'},
  {text: 'Client', value: 'orderer.id'},
  {text: 'Voiture', value: 'car', width: '200'},
  {text: 'Prix (€)', value: 'totalPrice'},
  {text: 'Date de RDV', value: 'appointmentDate'},
  {text: 'Finalisé le', value: 'finalisedAt'},
  {text: 'Vendu ?', value: 'sold'},
  {text: 'Statut', value: 'status.name'},
  {text: 'Statut du paiement', value: 'progression'},
];
const carHeaders = [
  {text: 'Nom', value: 'identity.name'},
  {text: 'Puissance (ch)', value: 'power'},
  {text: 'Poids (kg)', value: 'weight'},
  {text: 'Prix (€)', value: 'totalPrice'},
  {text: 'Date de RDV', value: 'appointmentDate'},
  {text: 'Finalisé le', value: 'finalisedAt'},
  {text: 'Vendu ?', value: 'sold'},
  {text: 'Statut', value: 'status.name'},
  {text: 'Statut du payement', value: 'progression'},
]

const handleGarageClick = async (garage) => {
  console.log(garage);
  orders.value = await GarageService.getGarageOrders(garage.id);
  cars.value = await CarService.getGarageCars(garage.id);
};

onMounted(async () => {
  const me = await UserService.get("me");
  if (me.roles.includes("ROLE_OWNER") || me.roles.includes("ROLE_ADMIN")) {
    garages.value = await GarageService.getCollection({
      "itemsPerPage": 100,
      "order[isOpen]": "desc",
      "owner.id": me.id,
    });
  }
});
</script>

<template>
  <div class="container mx-auto my-5">
    <div class="flex flex-col justify-between items-center gap-4">
      <div class="flex justify-between" v-if="garages.length > 0">

        <GarageListWithMap :garages="garages" :handle-garage-click="handleGarageClick" search/>

        <div class="flex justify-between">
          <RadioGroup class="self-end" :options="radioOptions" />
        </div>
      </div>


      <div class="w-full">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Commandes</h2>
        <Vue3EasyDataTable
            table-class-name="w-full text-sm text-left text-gray-500 dark:text-gray-400"
            header-class-name="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            body-row-class-name="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
            :items="orders"
            :headers="orderHeaders"
            buttons-pagination
        >
          <template #loading>
            <div class="flex justify-center items-center">
              <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-gray-900"></div>
            </div>
          </template>
          <template #item-car="item">
            <div class="flex items-center">
              <img :src="item.car.identity.mainPicture.src" class="w-10 h-10 rounded-full"  :alt="item.car.identity.name"/>
              <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">
                  {{ item.car.identity.name }}
                </div>
                <div class="text-sm text-gray-500">
                  {{ item.car.identity.category.name }}
                </div>
              </div>
            </div>
          </template>
          <template #item-appointmentDate="{appointmentDate}">
            {{ (appointmentDate) ? new Date(appointmentDate).toLocaleDateString() : 'Non défini' }}
          </template>
          <template #item-finalisedAt="{finalisedAt}">
            {{ (finalisedAt) ? new Date(finalisedAt).toLocaleDateString() : 'Non défini' }}
          </template>
          <template #item-sold="{sold}">
            {{ sold ? 'Oui' : 'Non' }}
          </template>
        </Vue3EasyDataTable>
      </div>

      <div class="w-full" v-if="cars.length > 0">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
          Voitures Disponibles
        </h2>
        <CarList :cars="cars" />
      </div>
    </div>
  </div>
</template>


<style scoped>

</style>
