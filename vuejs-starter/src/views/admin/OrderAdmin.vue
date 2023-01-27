<script setup>
    import { ref, onMounted } from 'vue';
    import orderService from "../../services/order.service";

    const orders = ref([]);
    const loading = ref(true);
    const currentPage = ref(1);

    onMounted(async () => {
        orders.value = await orderService.getCollection({page: currentPage.value});
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
            await orderService.getCollection({page: currentPage.value}).then(response => {
                orders.value = response;
                loading.value = false;
            }).catch(error => {
                console.log(error)
            });
        }
    };

    const nextPage = async () => {
        currentPage.value++;
        await orderService.getCollection({page: currentPage.value}).then(response => {
            orders.value = response;
            loading.value = false;
        }).catch(error => {
            console.log(error)
        });
    };
</script>

<template>
    <div>
      <h1>Admin Panel</h1>
      <h2>Orders</h2>
      <button @click="">Create Order</button>
      <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">User Id</th>
                <th scope="col">Car Id</th>
                <th scope="col">Date</th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="order in orders" :key="order.id">
                <th scope="row">{{ order.id }}</th>
                <td>{{ order.orderer.id }}</td>
                <td>{{ order.car.id }}</td>
                <td>{{ order.finalisedAt }}</td>
                <td>{{ order.totalPrice }}</td>
                <td>{{ order.status.slug }}</td>
                <td>
                    <button @click="">Edit</button>
                    <button @click="deleteOrders(order.id)">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
    <button @click="previousPage">Previous</button>
    <button @click="nextPage">Next</button>
    </div>
</template>
  


<style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #796666;
    }

</style> 