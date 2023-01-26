<script setup>
import { reactive, onMounted } from 'vue';
import OrderService from "../../../services/order.service.js";
import CarService from "../../../services/car.service.js";
import ImageService from "../../../services/image.service.js";

const orders = reactive([]);

onMounted(async () => {
    orders.values = await OrderService.getUserOrders('me');

    for await (const order of orders.values) {
        let car = await CarService.get(order.car.id);
        car.images = await ImageService.getCarImages(car.id);
        order.car = car;
    }

    console.log(orders.values);
});

</script>
<template>
    <div v-for="order in orders.values" class="py-3">
        <div class="w-5/6 h-52 rounded-lg bg-white/20 flex shadow-inner shadow-slate-200">
            <div class="relative w-1/5 h-full">
                <div class="absolute -left-32 -top-5 h-52 w-96 hover:scale-110 duration-300 ease-in-out bg-cover">
                    <img :src="order.car.images[0].src" class="h-full w-full object-cover bg-cover" />
                </div>
            </div>
            <div class="relative w-2/3 py-5 flex flex-col space-y-5 ml-10 item-start">
                <div class="flex flex-col">
                    <span>{{ order.car.name }} - {{ car }}</span>
                    <span>{{ order.car.year }}</span>
                    <span>Chasis: {{ order.car.slug }}</span>
                </div>
                <div class="flex w-full justify-between text-right">
                    <span class="min-w-[3rem]" />
                    <span class="min-w-[3rem]">Commandé</span>
                    <span class="min-w-[3rem]">Payé</span>
                    <span class="min-w-[3rem]">Contrôle technique</span>
                    <span class="min-w-[3rem]">Livraison</span>
                    <span class="min-w-[3rem]">Livré</span>
                </div>
                <div>
                    <div class="w-full bg-white/20 shadow-md rounded-full h-2">
                        <div class="bg-blue-500/60 shadow-inner shadow-blue-300 rounded-full h-full" style="width: 20%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

