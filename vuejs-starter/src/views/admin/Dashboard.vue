<script setup>
    import { ref, onMounted } from 'vue';
    import carService from "../../services/car.service";
    import userService from "../../services/user.service";
    import orderService from "../../services/order.service";

    const users = ref([]);
    const voiture = ref([]);
    const orders = ref([]);
    const loading = ref(true);
    const limit = ref(10);
    const currentPage = ref(1);

    onMounted(async () => {
        users.value = await userService.getCollection();
        voiture.value = await carService.getCarCollection();
        orders.value = await orderService.getCollection();
    });
</script>
<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Dashboard</h1>
                <p>Here you can see all the users, cars and orders</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>Users</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Email</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.slice(0, limit)" :key="user.id">
                            <th scope="row">{{ user.id }}</th>
                            <td>{{ user.email }}</td>
                            <td>{{ user.firstName }}</td>
                            <td>{{ user.lastName }}</td>
                            <td>{{ user.role }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>Cars</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Model</th>
                            <th scope="col">Price</th>
                            <th scope="col">Year</th>
                            <th scope="col">Fuel</th>
                            <th scope="col">Kilometers</th>
                            <th scope="col">Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="car in voiture" :key="car.id">
                            <th scope="row">{{ car.id }}</th>
                            <td>BMW {{ car.identity.name }}</td>
                            <td>{{ car.identity.category.name }}</td>
                            <td>{{ car.price }}</td>
                            <td>{{ car.year }}</td>
                            <td>{{ car.fuel }}</td>
                            <td>{{ car.mileage }}</td>
                            <td><img :src="car.images[0].src" width="150"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>Orders</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">User Id</th>
                            <th scope="col">Car Id</th>
                            <th scope="col">Date</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders.slice(0, limit)" :key="order.id">
                            <th scope="row">{{ order.id }}</th>
                            <td>{{ order.orderer.id }}</td>
                            <td>{{ order.car.id }}</td>
                            <td>{{ order.finalisedAt }}</td>
                            <td>{{ order.totalPrice }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<style>
    .container {
        margin-top: 50px;
    }

    .row {
        margin-top: 50px;
    }

    .col-12 {
        margin-top: 50px;
    }

    .table {
        margin-top: 50px;
    }

    .table td {
        text-align: center;
    }

    .table th {
        text-align: center;
    }

    .table thead th {
        border-bottom: 1px solid #dee2e6;
    }

    .table tbody + tbody {
        border-top: 1px solid #dee2e6;
    }

    .table .table {
        background-color: #fff;
    }

    .table-sm td,
    .table-sm th {
        padding: 0.3rem;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #dee2e6;
    }

    .table-bordered thead td,
    .table-bordered thead th {
        border-bottom-width: 2px;
    }

    .table-borderless tbody + tbody,
    .table-borderless td,
    .table-borderless th,
    .table-borderless thead th {
        border: 0;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .table-hover tbody tr:hover {
        color: #212529;
        background-color: rgba(0, 0, 0, 0.075);
    }

    .table-primary,
    .table-primary > td,
    .table-primary > th {
        background-color: #b8daff;
    }

    .table-primary tbody + tbody,
    .table-primary td,
    .table-primary th,
    .table-primary thead th {
        border-color: #7abaff;
    }

    .table-hover .table-primary:hover {
        background-color: #9fcdff;
    }

    .table-hover .table-primary:hover > td,
    .table-hover .table-primary:hover > th {
        background-color: #9fcdff;
    }

    .table-secondary,
    .table-secondary > td,
    .table-secondary > th {
        background-color: #d6d8db;
    }
</style>