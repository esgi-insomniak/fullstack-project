<script setup>
import {
    ref,
    onMounted
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

const orders = ref([]);
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

const deleteOrders = async (id) => {
    await orderService.delete(id).then(response => {
        console.log(response);
    }).catch(error => {
        alert('La commande ne peut être supprimer, elle est lié à une voiture et/ou un utilisateur')
        console.log(error)
    });
};

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
</script>

<template>
<div class="h-[75vh] overflow-scroll scrollbar-hide">
    <div class="flex justify-between w-full">
        <h2 class="text-2xl uppercase tracking-widest">Commandes</h2>
        <button class="flex items-center justify-center min-w-[15rem]">Ajouter une commande <PlusCircleIcon class="w-5 h-5 ml-3" /></button>
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
                <button @click="editUser(user.id)" class="mr-3 flex items-center justify-center min-w-[8rem]">Modifier <PencilSquareIcon class="h-5 w-5 ml-3" /></button>
                <button @click="deleteUser(user.id)" class="ml-3 flex items-center justify-center min-w-[8rem]">Supprimer <TrashIcon class="h-5 w-5 ml-3" /></button>
            </td>
        </tr>
    </table>
</div>
<div class="flex justify-end my-5 space-x-3">
    <button @click="previousPage" class="bg-blue-900 min-w-[10rem]"><ChevronLeftIcon  class="h-7 w-7 mx-auto" /></button>
    <button @click="nextPage" class="bg-blue-900 min-w-[10rem]"><ChevronRightIcon  class="h-7 w-7 mx-auto" /></button>
</div>
</template>
