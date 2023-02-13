<script setup>
import { onMounted, reactive, ref } from "vue";
import GarageService from "../../services/garage.service.js";
import UserService from "../../services/user.service.js";
import CarService from "../../services/car.service.js";
import SchudleService from "../../services/schudle.service.js";
import OrderService from "../../services/order.service.js";
import RecoveryService from "../../services/recovery.service";
import StatusService from "../../services/status.service.js";
import Vue3EasyDataTable from 'vue3-easy-data-table';
import RadioGroup from "../../components/RadioGroup.vue";
import CarList from "../../components/garage/CarList.vue";
import GarageListWithMap from "../../components/garage/GarageListWithMap.vue";
import Modal from "../../components/Modal.vue";
import { ExclamationTriangleIcon, PencilSquareIcon } from "@heroicons/vue/24/outline/index.js";
import moment from 'moment/dist/moment';
import fr from 'moment/dist/locale/fr';
moment.locale('fr', fr);

const garages = ref([]);
const selectedGarage = ref(null);
const orders = ref([]);
const recoveries = ref([]);
const cars = ref([]);
const meetings = ref([]);
const statusAvailable = ref([]);

const selectedRadio = ref(null);

const formData = ref({
  name: '',
  is_open: false,
});

const radioOptions = [
  { label: 'Commandes', id: 'orders' },
  { label: 'Reprises', id: 'recoveries' },
  { label: 'Voitures', id: 'cars' },
  { label: 'Rendez-vous', id: 'meetings' },
];
const orderHeaders = [
  { text: 'ID', value: 'id' },
  { text: 'Client', value: 'orderer' },
  { text: 'Voiture', value: 'car', width: '200' },
  { text: 'Prix (€)', value: 'totalPrice' },
  { text: 'Date de RDV', value: 'appointmentDate' },
  { text: 'Finalisé le', value: 'finalisedAt' },
  { text: 'Vendu ?', value: 'sold' },
  { text: 'Statut', value: 'status.name' },
  { text: 'Statut du paiement', value: 'progression' },
  { text: 'Actions', value: 'actions', sortable: false },
];
const RecoverHeaders = [
  { text: 'ID', value: 'id' },
  { text: 'Client', value: 'recoverer' },
  { text: 'Voiture', value: 'carIdentity', width: '200' },
  { text: 'Prix Estimé(€)', value: 'proposedPrice' },
  { text: 'Statut', value: 'status.name' },
  { text: 'Statut de la vente', value: 'progression' },
  { text: 'Année', value: 'year'},
  { text: 'Kilomètres', value: 'kilometers'},
  { text: 'Carburant', value: 'fuel'},
  { text: 'Boite de vitesse', value: 'gearbox'},
  { text: 'CV', value: 'power'},
  { text: 'Description', value: 'carDescription'},
  { text: 'Actions', value: 'actions', sortable: false },
];
const meetingHeaders = [
  { text: 'ID', value: 'id' },
  { text: 'Type', value: 'type' },
  { text: 'Date de RDV', value: 'appointmentDate' },
  { text: 'Client', value: 'associateUser' },
  { text: 'Commande Liée', value: 'associateOrder' },
  { text: 'Voiture', value: 'carIdentity', width: '200' },
  { text: 'Raison', value: 'reason' },
  { text: 'Kilomètres', value: 'kilometers' },
  { text: 'Carburant', value: 'fuel' },
  { text: 'Boite de vitesse', value: 'gearbox' },
  { text: 'Actions', value: 'actions', sortable: false },
]
const toggleModal = () => {
  modalProps.open = !modalProps.open
};

const modalProps = reactive({
  open: false,
  toggle: toggleModal,
});

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
  formData.value.name = garage.name;
  formData.value.is_open = garage.is_open === true ? 'true' : 'false';
  orders.value = await GarageService.getGarageOrders(garage.id);
  recoveries.value = await RecoveryService.getGarageRecoveries(garage.id);
  cars.value = await CarService.getGarageCars(garage.id);
  meetings.value = await SchudleService.getGarageEvents(garage.id);
};

const cancelOrder = async (order) => {
  const updatedOrder = await OrderService.patch(order.id, { progression: 'canceled' });
  orders.value = orders.value.map((o) => {
    if (o.id === order.id) {
      o.progression = updatedOrder.progression;
      o.status.canCancel = updatedOrder.status.canCancel;
    }
    return o;
  });
  toggleModal();
};

const editOrder = async (order) => {
  const updatedOrder = await OrderService.patch(order.id, {
    status: `statuses/${order.status.id}`
  });
  const status = await StatusService.get(order.status.id);
  orders.value = orders.value.map((o) => {
    if (o.id === updatedOrder.id) {
      o.status = status;
      o.progression = updatedOrder.progression;
      o.finalisedAt = updatedOrder.finalisedAt;
    }
    return o;
  });
  toggleModal();
};

const cancelRecovery = async (recovery) => {
  const updatedRecovery = await RecoveryService.patch(recovery.id, { progression: 'canceled' });
  recoveries.value = recoveries.value.map((o) => {
    if (o.id === recovery.id) {
      o.progression = updatedRecovery.progression;
      o.status.canCancel = updatedRecovery.status.canCancel;
    }
    return o;
  });
  toggleModal();
};

const editRecovery = async (recovery) => {
  const updatedRecovery = await RecoveryService.patch(recovery.id, {
    status: `statuses/${recovery.status.id}`
  });
  const status = await StatusService.get(recovery.status.id);
  recoveries.value = recoveries.value.map((o) => {
    if (o.id === updatedRecovery.id) {
      o.status = status;
      o.progression = updatedRecovery.progression;
    }
    return o;
  });
  toggleModal();
};

const loadCancelOrderModal = (order) => {
  modalProps.id = 'cancel-order-modal';
  modalProps.title = 'Annuler la commande ?';
  modalProps.content = 'Si vous annulez la commande, vous ne pourrez plus revenir en arrière. Voulez-vous vraiment annuler la commande ?'
  modalProps.icon = {
    type: ExclamationTriangleIcon,
    bgColor: 'bg-red-100',
    textColor: 'text-red-600'
  };
  modalProps.buttons = [
    {
      text: 'Annuler la commande',
      class: 'inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm',
      action: async () => await cancelOrder(order)
    },
    {
      text: 'Fermer',
      class: 'mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm',
      action: toggleModal
    }
  ]
  toggleModal();
};

const loadEditOrderModal = async (order) => {
  modalProps.id = 'order-edit-modal';
  modalProps.title = 'Modifier la commande';
  modalProps.content = null;
  modalProps.icon = {
    type: PencilSquareIcon,
    bgColor: 'bg-green-100',
    textColor: 'text-green-600'
  };
  modalProps.order = order;
  modalProps.buttons = [
    {
      text: 'Modifier',
      class: 'inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm',
      action: async () => await editOrder(order)
    },
    {
      text: 'Fermer',
      class: 'mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm',
      action: toggleModal
    }
  ]
  statusAvailable.value = await StatusService.getCollection();
  toggleModal();
}

const loadCancelRecoveryModal = (recovery) => {
  modalProps.id = 'cancel-recovery-modal';
  modalProps.title = 'Annuler la vente ?';
  modalProps.content = 'Si vous annulez la vente, vous ne pourrez plus revenir en arrière. Voulez-vous vraiment annuler la commande ?'
  modalProps.icon = {
    type: ExclamationTriangleIcon,
    bgColor: 'bg-red-100',
    textColor: 'text-red-600'
  };
  modalProps.buttons = [
    {
      text: 'Annuler la vente',
      class: 'inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm',
      action: async () => await cancelRecovery(recovery)
    },
    {
      text: 'Fermer',
      class: 'mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm',
      action: toggleModal
    }
  ]
  toggleModal();
};

const loadEditRecoveryModal = async (recovery) => {
  modalProps.id = 'recovery-edit-modal';
  modalProps.title = 'Modifier la vente';
  modalProps.content = null;
  modalProps.icon = {
    type: PencilSquareIcon,
    bgColor: 'bg-green-100',
    textColor: 'text-green-600'
  };
  modalProps.recovery = recovery;
  modalProps.buttons = [
    {
      text: 'Modifier',
      class: 'inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm',
      action: async () => await editRecovery(recovery)
    },
    {
      text: 'Fermer',
      class: 'mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm',
      action: toggleModal
    }
  ]
  statusAvailable.value = await StatusService.getCollection();
  toggleModal();
}

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

  <Modal v-bind="{ ...modalProps }">
    <div v-if="modalProps.id === 'order-edit-modal'" class="px-6">
      <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Changer le status</label>
      <select id="status" v-model="modalProps.order.status.id"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option v-for="status in statusAvailable" :value="status.id" :key="status.id">{{ status.name }}</option>
      </select>
    </div>
    <div v-if="modalProps.id === 'recovery-edit-modal'" class="px-6">
      <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Changer le status</label>
      <select id="status" v-model="modalProps.recovery.status.id"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option v-for="status in statusAvailable" :value="status.id" :key="status.id">{{ status.name }}</option>
      </select>
    </div>
  </Modal>


  <div class="container mx-auto my-5">
    <div class="flex flex-col justify-between items-center gap-4" v-if="garages.length > 0">
      <div class="flex justify-between">
        <GarageListWithMap :garages="garages" :handle-garage-click="handleGarageClick" search />
        <div class="flex justify-between">
          <RadioGroup class="self-end w-64" :options="radioOptions" @on-selected="handleRadioSelected" />
        </div>
      </div>

      <template v-if="selectedGarage">
        <div class="w-full p-6">
          <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-2">Informations générales</h2>
          <FormKit @submit="handleSubmit" v-model="formData" type="form"
            form-class="grid grid-flow-row grid-cols-2 gap-3" submit-label="Mettre à jour">
            <FormKit type="text" name="name" label="Nom du garage" placeholder="Nom" />
            <FormKit type="checkbox" label="Ouvert ?" help="Le garage est-il ouvert et accepte des offres ?"
              name="is_open" />
          </FormKit>
        </div>


        <div class="w-full p-6" v-show="selectedRadio === 'orders'">
          <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-2">Commandes</h2>
          <Vue3EasyDataTable table-class-name="customize-table" :items="orders" :headers="orderHeaders"
            :rows-per-page="10" buttons-pagination>
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
                <img :src="item.car.identity.mainPicture.src" class="object-cover rounded-full"
                  :alt="item.car.identity.name" />
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
            <template #item-appointmentDate="{ appointmentDate }">
              {{ (appointmentDate) ? moment(appointmentDate).format("lll") : 'Non défini' }}
            </template>
            <template #item-finalisedAt="{ finalisedAt }">
              {{ (finalisedAt) ? moment(finalisedAt).format("lll") : 'Non défini' }}
            </template>
            <template #item-sold="{ sold }">
              {{ sold? 'Oui': 'Non' }}
            </template>
            <template #item-actions="item">
              <div class="flex items-center space-x-4">
                <button class="text-indigo-600 hover:text-indigo-900"
                  @click="loadEditOrderModal(item)">Modifier</button>
                <button class="text-indigo-600 hover:text-indigo-900"
                  @click="loadCancelOrderModal(item)">Annuler</button>
              </div>
            </template>
          </Vue3EasyDataTable>
        </div>

        <div class="w-full p-6" v-show="selectedRadio === 'recoveries'">
          <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-2">Reprises</h2>
          <Vue3EasyDataTable table-class-name="customize-table" :items="recoveries" :headers="RecoverHeaders"
            :rows-per-page="10" buttons-pagination>
            <template #item-recoverer="item">
              <div class="flex items-center">
                <div class="ml-4">
                  <div class="text-sm font-medium">
                    {{ item.recoverer.firstName }} {{ item.recoverer.lastName }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ item.recoverer.email }}
                  </div>
                </div>
              </div>
            </template>

            <template #item-carIdentity="item">
              <div class="flex items-center" v-if="item.carIdentity">
                <img :src="item.carIdentity.mainPicture.src" class="object-cover rounded-full"
                  :alt="item.carIdentity.name" />
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
            <template #item-actions="item">
              <div class="flex items-center space-x-4">
                <button class="text-indigo-600 hover:text-indigo-900"
                  @click="loadEditRecoveryModal(item)">Modifier</button>
                <button class="text-indigo-600 hover:text-indigo-900"
                  @click="loadCancelRecoveryModal(item)">Annuler</button>
              </div>
            </template>
          </Vue3EasyDataTable>
        </div>

        <div class="w-full p-6" v-show="selectedRadio === 'meetings'">
          <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-2">Rendez-vous</h2>
          <Vue3EasyDataTable table-class-name="customize-table" :items="meetings" :headers="meetingHeaders"
            :rows-per-page="10" buttons-pagination>
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

            <template #item-appointmentDate="item">
              {{ moment(item.dateStart).format("lll") }}
            </template>

            <template #item-associateOrder="item">
              {{ item.associateOrder?.id ?? 'Non défini' }}
            </template>

            <template #item-carIdentity="item">
              <div class="flex items-center" v-if="item.carIdentity">
                <img :src="item.carIdentity.mainPicture.src" class="object-cover rounded-full"
                  :alt="item.carIdentity.name" />
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
