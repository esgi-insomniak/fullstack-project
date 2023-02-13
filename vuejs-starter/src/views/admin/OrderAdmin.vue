<script setup>
import {
    ref,
    onMounted,
    reactive
} from 'vue';
import orderService from "../../services/order.service";
import {
    UserPlusIcon,
    ChevronLeftIcon,
    ChevronRightIcon,
    TrashIcon,
    PencilSquareIcon,
    PlusCircleIcon
} from '@heroicons/vue/24/outline';
import Modal from "../../components/Modal.vue";

const orders = ref([]);
const myOrder = ref({});
const loading = ref(true);
const currentPage = ref(1);
const thead = [{
        id: 'id',
        label: 'ID'
    },
    {
        id: 'userId',
        label: 'User Id'
    },
    {
        id: 'carId',
        label: 'Car Id'
    },
    {
        id: 'date',
        label: 'Date'
    },
    {
        id: 'price',
        label: 'Price'
    },
    {
        id: 'status',
        label: 'Status'
    },
    {
        id: 'actions',
        label: 'Actions'
    },
];

onMounted(async () => {
    orders.value = await orderService.getCollection({
        page: currentPage.value
    });
    loading.value = false;
});

const previousPage = async () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        await orderService.getCollection({
            page: currentPage.value
        }).then(response => {
            orders.value = response;
            loading.value = false;
        }).catch(error => {
            console.log(error)
        });
    }
};

const nextPage = async () => {
    currentPage.value++;
    await orderService.getCollection({
        page: currentPage.value
    }).then(response => {
        orders.value = response;
        loading.value = false;
        // if there is no more users, go back to the previous page
        if (orders.value.length === 0) {
            previousPage();
        }
    }).catch(error => {
        console.log(error)
    });
};

const editOrder = async (order) => {
    await orderService.patch(order.id, order).then(user => {
      orders.value = orders.value.map((o) => {
        if (o.id === order.id) {
          o = order;
        }
        return o;
    });
        toggleModal();
    }).catch(error => {
        console.log(error)
    });
};

const deleteOrder = async (user) => {
    await orderService.delete(user.id).then(response => {
        orders.value = orders.value.filter((o) => o.id !== order.id);
        toggleModal();
    }).catch(error => {
        console.log(error)
    });
};

const loadModificationModal = async (order) => {
    myOrder.value = await orderService.get(order.id);
    modalProps.id = 'modification';
    modalProps.title = `Modification de la commande ${myOrder.value.id}`;
    modalProps.content = 'Modification de la commande';
    modalProps.icon = {
        type: PencilSquareIcon,
        bgColor: 'bg-blue-100',
        textColor: 'text-blue-600'
    };
    modalProps.buttons = [
        {
            text: 'Annuler',
            class: 'mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm',
            action: toggleModal
        },
        {
            text: 'Modifier',
            class: 'inline-flex w-full justify-center rounded-md border border-transparent px-4 py-2 text-base font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm bg-green-600 hover:bg-green-700 focus:ring-green-500',
            action: async () => editOrder(myOrder.value)
        }
    ]
    toggleModal();
}

const loadDeleteModal = async (order) => {
    myOrder.value = await orderService.get(order.id);
    modalProps.id = 'delete';
    modalProps.title = `Suppression de la commande ${myOrder.value.id}`;
    modalProps.content = 'Suppression de la commande';
    modalProps.icon = {
        type: TrashIcon,
        bgColor: 'bg-blue-100',
        textColor: 'text-blue-600'
    };
    modalProps.buttons = [
        {
            text: 'Annuler',
            class: 'mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm',
            action: toggleModal
        },
        {
            text: 'Supprimer',
            class: 'inline-flex w-full justify-center rounded-md border border-transparent px-4 py-2 text-base font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm bg-green-600 hover:bg-green-700 focus:ring-green-500',
            action: async () => deleteOrder(myOrder.value)
        }
    ]
    toggleModal();
}

const toggleModal = () => {
    modalProps.open = !modalProps.open
};

const modalProps = reactive({
    open: false,
    toggle: toggleModal,
});

</script>

<template>
    <Modal v-bind="{ ...modalProps }">
        <div v-if="modalProps.id === 'modification'">
            <div class="flex flex-col">
                <label class="block text-sm font-medium text-gray-700">ID</label>
                <input type="text" v-model="myOrder.id" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                <label class="block text-sm font-medium text-gray-700">User ID</label>
                <input type="text" v-model="myOrder.orderer.id" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                <label class="block text-sm font-medium text-gray-700">Car ID</label>
                <input type="text" v-model="myOrder.car.id" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="text" v-model="myOrder.finalisedAt" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                <label class="block text-sm font-medium text-gray-700">Price</label>
                <input type="text" v-model="myOrder.totalPrice" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                <label class="block text-sm font-medium text-gray-700">Status</label>
                <input type="text" v-model="myOrder.progression" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
        </div>
    </Modal>
<div class="h-[75vh] overflow-scroll scrollbar-hide">
    <div class="flex justify-between w-full">
        <h2 class="text-2xl uppercase tracking-widest">Commandes</h2>
    </div>
    <table class="table-auto w-full mx-auto text-left my-5">
        <tr>
            <th class="p-3" v-for="head in thead" :key="head.id">{{ head.label }}</th>
        </tr>
        <tr v-for="(order, index) in orders" :key="order.id" :class="{'bg-gray-400': index % 2 === 0, 'text-black': index % 2 === 0}">
            <th class="p-3">{{ order.id }}</th>
            <td class="py-3">{{ order.orderer.id }}</td>
            <td class="py-3">{{ order.car.id }}</td>
            <td class="py-3">{{ order.finalisedAt }}</td>
            <td class="py-3">{{ order.totalPrice }}</td>
            <td class="py-3">{{ order.status.slug }}</td>
            <td class="py-3 flex" :class="{'text-white': index % 2 === 0}">
                <button @click="loadModificationModal(order)" class="mr-3 flex items-center justify-center min-w-[8rem]">Modifier <PencilSquareIcon class="h-5 w-5 ml-3" /></button>
                <button @click="loadDeleteModal(order)" class="ml-3 flex items-center justify-center min-w-[8rem]">Supprimer <TrashIcon class="h-5 w-5 ml-3" /></button>
            </td>
        </tr>
    </table>
</div>
<div class="flex justify-end my-5 space-x-3">
    <button @click="previousPage" class="bg-blue-900 min-w-[10rem]"><ChevronLeftIcon  class="h-7 w-7 mx-auto" /></button>
    <button @click="nextPage" class="bg-blue-900 min-w-[10rem]"><ChevronRightIcon  class="h-7 w-7 mx-auto" /></button>
</div>
</template>
