<script setup>
import {onMounted, ref} from "vue";
import GarageService from "../../services/garage.service.js";
import UserService from "../../services/user.service.js";
import CarService from "../../services/car.service.js";
import Vue3EasyDataTable from 'vue3-easy-data-table';
import RadioGroup from "../../components/RadioGroup.vue";
import CarList from "../../components/garage/CarList.vue";
import GarageListWithMap from "../../components/garage/GarageListWithMap.vue";
import SchudleService from "../../services/schudle.service.js";


const garages = ref([]);
const selectedGarage = ref(null);
const orders = ref([]);
const cars = ref([]);
const meetings = ref([]);

const selectedRadio = ref(null);

const formData = ref({
  name: '',
  is_open: false,
});

const radioOptions = [
  {label: 'Commandes', id: 'orders'},
  {label: 'Voitures', id: 'cars'},
  {label: 'Rendez-vous', id: 'meetings'},
];
const orderHeaders = [
  {text: 'ID', value: 'id'},
  {text: 'Client', value: 'orderer'},
  {text: 'Voiture', value: 'car', width: '200'},
  {text: 'Prix (€)', value: 'totalPrice'},
  {text: 'Date de RDV', value: 'appointmentDate'},
  {text: 'Finalisé le', value: 'finalisedAt'},
  {text: 'Vendu ?', value: 'sold'},
  {text: 'Statut', value: 'status.name'},
  {text: 'Statut du paiement', value: 'progression'},
  {text: 'Actions', value: 'actions', sortable: false},
];

const meetingHeaders = [
  {text: 'ID', value: 'id'},
  {text: 'Type', value: 'type'},
  {text: 'Client', value: 'associateUser'},
  {text: 'Commande Liée', value: 'associateOrder'},
  {text: 'Voiture', value: 'carIdentity', width: '200'},
  {text: 'Raison', value: 'reason'},
  {text: 'Date de RDV', value: 'appointmentDate'},
  {text: 'Kilomètres', value: 'kilometers'},
  {text: 'Carburant', value: 'fuel'},
  {text: 'Boite de vitesse', value: 'gearbox'},
  {text: 'Actions', value: 'actions', sortable: false},
]

const handleSubmit = (form) => {
  if (selectedGarage.value) {
    const garageUpdated = GarageService.patch(selectedGarage.value.id, form);
    //update garage in list
    garages.value = garages.value.map(g => {
      if (g.id === garageUpdated.id) {
        //update only name and is_open
        g.name = garageUpdated.name;
        g.is_open = garageUpdated.is_open;
      }
      return g;
    });
  }
};

const handleRadioSelected = (selected) => {
  selectedRadio.value = selected;
};


const handleGarageClick = async (garage) => {
  selectedGarage.value = garage;
  orders.value = await GarageService.getGarageOrders(garage.id);
  cars.value = await CarService.getGarageCars(garage.id);
  meetings.value = await SchudleService.getGarageEvents(garage.id);
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
    <div class="flex flex-col justify-between items-center gap-4" v-if="garages.length > 0">
      <div class="flex justify-between" >
        <GarageListWithMap :garages="garages" :handle-garage-click="handleGarageClick" search/>
        <div class="flex justify-between">
          <RadioGroup class="self-end w-64" :options="radioOptions" @on-selected="handleRadioSelected" />
        </div>
      </div>

      <template v-if="selectedGarage">
      <div class="w-full p-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-2">Informations générales</h2>
        <FormKit @submit="handleSubmit" v-model="formData" type="form" form-class="grid grid-flow-row grid-cols-2 gap-3" submit-label="Mettre à jour">
          <FormKit type="text" name="name" label="Nom du garage" placeholder="Nom" />
          <FormKit
            type="checkbox"
            label="Ouvert ?"
            help="Le garage est-il ouvert et accepte des offres ?"
            name="is_open"
            :value="true"
          />
        </FormKit>
      </div>


      <div class="w-full p-6" v-show="selectedRadio === 'orders'">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-2">Commandes</h2>
        <Vue3EasyDataTable
            table-class-name="customize-table"
            :items="orders"
            :headers="orderHeaders"
            :rows-per-page="10"
            buttons-pagination
        >
          <template #item-orderer="item">
            <div class="flex items-center">
              <div class="ml-4">
                <div class="text-sm font-medium">
                  {{ item.orderer.firstName }} {{ item.orderer.lastName }}
                </div>
                <div class="text-sm text-gray-500">
                  {{ item.orderer.email }}
                </div>
              </div>
            </div>
          </template>
          <template #item-car="item">
            <div class="flex items-center">
              <img :src="item.car.identity.mainPicture.src" class="object-cover rounded-full"  :alt="item.car.identity.name"/>
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
          <template #item-actions="item">
            <div class="flex items-center space-x-4">
              <button class="text-indigo-600 hover:text-indigo-900">Modifier</button>
              <button class="text-indigo-600 hover:text-indigo-900">Annuler</button>
            </div>
          </template>
        </Vue3EasyDataTable>
      </div>

      <div class="w-full p-6" v-show="selectedRadio === 'meetings'">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-2">Rendez-vous</h2>
        <Vue3EasyDataTable
            table-class-name="customize-table"
            :items="meetings"
            :headers="meetingHeaders"
            :rows-per-page="10"
            buttons-pagination
        >
          <template #item-associateUser="item">
            <div class="flex items-center">
              <div class="ml-4">
                <div class="text-sm font-medium">
                  {{ item.associateUser.firstName }} {{ item.associateUser.lastName }}
                </div>
                <div class="text-sm text-gray-500">
                  {{ item.associateUser.email }}
                </div>
              </div>
            </div>
          </template>
          <template #item-carIdentity="item">
            <div class="flex items-center">
              <img :src="item.carIdentity.mainPicture.src" class="object-cover rounded-full"  :alt="item.carIdentity.name"/>
              <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">
                  {{ item.carIdentity.name }}
                </div>
                <div class="text-sm text-gray-500">
                  {{ item.carIdentity.category.name }}
                </div>
              </div>
            </div>
          </template>
        </Vue3EasyDataTable>
      </div>

      <div class="w-full p-6" v-if="cars.length > 0" v-show="selectedRadio === 'cars'">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
          Voitures Disponibles
        </h2>
        <CarList :cars="cars" only-show />
      </div>
      </template>
    </div>
  </div>
</template>


<style scoped>

</style>
