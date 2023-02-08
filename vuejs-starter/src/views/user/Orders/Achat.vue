<script setup>
import { reactive, onMounted, ref } from 'vue';
import { onBeforeRouteUpdate, useRoute } from 'vue-router';
import OrderService from "../../../services/order.service.js";
import Modal from "../../../components/Modal.vue";
import { ExclamationTriangleIcon, CurrencyEuroIcon } from '@heroicons/vue/24/outline';

const route = useRoute();
const orders = reactive([]);
const slug = ref(route.params.slug);

onMounted(async () => {
    orders.values = await OrderService.getUserOrders('me');
});

onBeforeRouteUpdate(async (to) => {
    slug.value = to.params.slug;
});

const filterOrders = () => {
    if (slug.value && slug.value !== 'all') {
        return Object.values(orders.values).filter((order) => order.progression === slug.value);
    }
    return orders.values;
};

const payOnline = async (order) => {
    if (order.progression !== 'in-progress' || order.status.slug !== 'waiting-for-payment') returnz
    const checkout = await OrderService.postStripeCheckout(order.id);
    window.location.href = checkout.url;
    toggleModal();
};

const cancelOrder = async (order) => {
    if (!order.status.canCancel || order.progression !== 'in-progress') return
    const updatedOrder = await OrderService.patch(order.id, { progression: 'canceled' });
    orders.values = orders.values.map((o) => {
        if (o.id === order.id) {
            o.progression = updatedOrder.progression;
            o.status.canCancel = updatedOrder.status.canCancel;
        }
        return o;
    });
    toggleModal();
};

const loadCancelModal = (order) => {
    if (!order.status.canCancel || order.progression !== 'in-progress') return
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

const loadDetailsModal = (order) => {
    modalProps.title = 'Détails de la commande';
    modalProps.content = `Order number: ${order.id}<br>Année: ${order.car.year}<br>Status: ${order.status.name}<br>Montant: ${order.car.price} €`;
    modalProps.icon = null;
    modalProps.buttons = [
        {
            text: 'Fermer',
            class: 'mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm',
            action: toggleModal
        }
    ]
    toggleModal();
}

const loadPaymentModal = (order) => {
    if (order.progression !== 'in-progress' || order.status.slug !== 'waiting-for-payment') return
    modalProps.title = 'Payer la commande';
    modalProps.content = null;
    modalProps.icon = {
        type: CurrencyEuroIcon,
        bgColor: 'bg-green-100',
        textColor: 'text-green-600'
    };
    modalProps.buttons = [
        {
            text: 'Payer',
            class: 'inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm',
            action: async () => await payOnline(order)
        },
        {
            text: 'Fermer',
            class: 'mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm',
            action: toggleModal
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
    <Modal v-bind="{ ...modalProps }" />
    <div class="bg-blue-500/60 " />
    <div class="bg-yellow-500/60" />
    <div class="bg-green-500/60" />
    <div v-for="order in filterOrders()" :key="order.id" class="py-3">
        <div class="w-full h-52 rounded-lg bg-white/20 flex shadow-inner shadow-slate-200">
            <div class="relative w-1/5 h-full">
                <div class="absolute -left-32 -top-5 h-52 w-96 hover:scale-110 duration-300 ease-in-out bg-cover">
                    <img :src="order.car.images[0].src" class="h-full w-full object-cover bg-cover" />
                </div>
            </div>
            <div class="relative w-full py-5 px-5 flex flex-col space-y-5 ml-10 item-start">
                <div class="flex justify-between w-full h-full">
                    <div class="flex flex-col w-4/6">
                        <span>Modèle : {{ order.car.model }} - {{ order.car.year }}</span>
                        <span>Numéro du chassis : {{ order.car.slug }}</span>
                        <span>Prix : {{ order.car.price }} €</span>
                        <span>Status de la commande : {{ order.status.name }}</span>
                    </div>
                    <div class="flex flex-col w-2/6 h-full justify-end items-center">
                        <div v-if="order.progression === 'in-progress' && order.status.slug === 'waiting-for-payment'"
                            v-on:click="loadPaymentModal(order)"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded h-auto text-center hover:cursor-pointer w-[80%] max-w-[200px]">
                            Payer en ligne</div>
                    </div>
                    <div class="flex flex-col w-2/6 h-full justify-between items-center">
                        <div v-on:click="loadDetailsModal(order)"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded h-auto text-center hover:cursor-pointer w-[80%] max-w-[200px]">
                            Plus de détails</div>
                        <div class="text-white font-bold py-2 px-4 border rounded h-auto text-center w-[80%] max-w-[200px]"
                            v-on:click="loadCancelModal(order)"
                            :class="[(order.status.canCancel && order.progression === 'in-progress') ? 'border-red-500 bg-red-500 hover:bg-red-700 hover:cursor-pointer' : 'border-gray-500 bg-gray-500']">
                            Annuler</div>
                    </div>
                </div>
                <div class="flex w-full justify-between text-right">
                    <span class="min-w-[3rem]" />
                    <span class="min-w-[3rem]">Commandé</span>
                    <span class="min-w-[3rem]">Rendez-vous</span>
                    <span class="min-w-[3rem]">Payé</span>
                    <span class="min-w-[3rem]">Contrôle technique</span>
                    <span class="min-w-[3rem]">Livraison</span>
                    <span class="min-w-[3rem]">Livré</span>
                </div>
                <div>
                    <div class="w-full bg-white/20 shadow-md rounded-full h-2">
                        <div class="shadow-inner shadow-blue-300 rounded-full h-full" :class="order.status.bgColor"
                            :style="{ width: order.status.width }">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

