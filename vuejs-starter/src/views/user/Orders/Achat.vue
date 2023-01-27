<script setup>
import { reactive, onMounted } from 'vue';
import OrderService from "../../../services/order.service.js";

const orders = reactive([]);

onMounted(async () => {
    orders.values = await OrderService.getUserOrders('me');
});

</script>
<template>
    <div v-for="order in orders.values" class="py-3">
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
                    <div class="flex flex-col w-2/6 h-full justify-between items-center">
                        <div
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded h-auto text-center hover:cursor-pointer w-[80%] max-w-[200px]">
                            Plus de détails</div>
                        <div class="text-white font-bold py-2 px-4 border rounded h-auto text-center w-[80%] max-w-[200px]"
                            :class="[order.status.canCancel ? 'border-red-500 bg-red-500 hover:bg-red-700 hover:cursor-pointer' : 'border-gray-500 bg-gray-500']">
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

