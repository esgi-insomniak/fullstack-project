<script setup>
import {
    ref,
    onMounted
} from 'vue';
import carService from "../../services/car.service";
import userService from "../../services/user.service";
import orderService from "../../services/order.service";

const users = ref([]);
const voiture = ref([]);
const orders = ref([]);
const loading = ref(true);
const limit = ref(10);
// make currentPage const to be the last of the users
const currentPage = ref()
const orderDesc = ref(false)
const theadUser = [{
        id: 'id',
        label: 'ID'
    },
    {
        id: 'firstName',
        label: 'Prenom'
    },
    {
        id: 'lastName',
        label: 'Nom'
    },
    {
        id: 'email',
        label: 'Email'
    },
    {
        id: 'actions',
        label: 'Actions'
    },
];
const theadOrder = [{
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
        id: 'actions',
        label: 'Actions'
    },
];
const theadCar = [{
        id: 'id',
        label: 'ID'
    },
    {
        id: 'brand',
        label: 'Brand'
    },
    {
        id: 'model',
        label: 'Model'
    },
    {
        id: 'price',
        label: 'Price'
    },
    {
        id: 'year',
        label: 'Year'
    },
    {
        id: 'fuel',
        label: 'Fuel'
    },
    {
        id: 'kilometers',
        label: 'Kilometers'
    },
    {
        id: 'image',
        label: 'Image'
    },
    {
        id: 'actions',
        label: 'Actions'
    },
];

onMounted(async () => {
    users.value = await userService.getCollection();
    voiture.value = await carService.getCarCollection();
    orders.value = await orderService.getCollection();
});
</script>
<template>
<div class="">
    <div>
        <div class="w-full h-[70vh]">
            <h2 class="text-xl">Users</h2>
            <table class="table-auto w-full mx-auto text-left my-5">
                <thead>
                    <tr>
                        <th class="py-3 px-2" v-for="th in theadUser" :key="th.id">{{ th.label }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users.slice(0, limit)" :key="user.id" :class="{'bg-gray-400': index % 2 === 0, 'text-black': index % 2 === 0}">
                        <td class="py-3 px-2">{{ user.id }}</td>
                        <td class="py-3">{{ user.firstName }}</td>
                        <td class="py-3">{{ user.lastName }}</td>
                        <td class="py-3">{{ user.email }}</td>
                        <td class="py-3" :class="{'text-white': index % 2 === 0}">
                            <button class="mr-3" @click="editUser(user.id)">Edit</button>
                            <button class="ml-3" @click="deleteUser(user.id)">Delete</button>
                        </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="">
        <div class="">
            <h2 class="text-xl">Cars</h2>
            <table class="table-auto w-full mx-auto text-left my-5">
                <thead>
                    <tr>
                        <th class="py-3 px-2" v-for="th in theadCar" :key="th.id">{{ th.label }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(car, index) in voiture.slice(0, limit)" :key="car.id" :class="{'bg-gray-400': index % 2 === 0, 'text-black': index % 2 === 0}">
                        <td class="py-3 px-2">{{ car.id }}</td>
                        <td class="py-3">BMW {{ car.identity.name }}</td>
                        <td class="py-3">{{ car.identity.category.name }}</td>
                        <td class="py-3">{{ car.price }}</td>
                        <td class="py-3">{{ car.year }}</td>
                        <td class="py-3">{{ car.fuel }}</td>
                        <td class="py-3">{{ car.mileage }}</td>
                        <td class="py-3"><img :src="car.images[0].src" width="150"></td>
                        <td class="py-3" :class="{'text-white': index % 2 === 0}">
                            <button class="mr-3" @click="editCar(car.id)">Edit</button>
                            <button class="ml-3" @click="deleteCar(car.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="">
        <div class="">
            <h2 class="text-xl">Orders</h2>
            <table class="table-auto w-full mx-auto text-left my-5">
                <thead>
                    <tr>
                        <th class="py-3 px-2" v-for="th in theadOrder" :key="th.id">{{ th.label }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(order, index) in orders.slice(0, limit)" :key="order.id" :class="{'bg-gray-400': index % 2 === 0, 'text-black': index % 2 === 0}">
                        <td class="py-3 px-2">{{ order.id }}</td>
                        <td class="py-3">{{ order.orderer.id }}</td>
                        <td class="py-3">{{ order.car.id }}</td>
                        <td class="py-3">{{ order.finalisedAt }}</td>
                        <td class="py-3">{{ order.totalPrice }}</td>
                        <td class="py-3" :class="{'text-white': index % 2 === 0}">
                            <button class="mr-3" @click="editOrder(order.id)">Edit</button>
                            <button class="ml-3" @click="deleteOrder(order.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>