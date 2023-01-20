<script setup>
    import { ref, onMounted } from 'vue';
    import carService from "../../services/car.service";

    const cars = ref([]);
    const loading = ref(true);
    const currentPage = ref(1);

    onMounted(async () => {
        cars.value = await carService.getCarCollection({page: currentPage.value});
        loading.value = false;
    });

    const deleteCar = async (id) => {
        await carService.deleteCar(id).then(response => {
            console.log(response);
        }).catch(error => {
            alert('La voiture ne peut être supprimer, elle est lié à une commande')
            console.log(error)
        })
    };

    const previousPage = async () => {
        if(currentPage.value > 1) {
            currentPage.value--;
            await carService.getCarCollection({page: currentPage.value}).then(response => {
                cars.value = response;
                loading.value = false;
            }).catch(error => {
                console.log(error)
            })
        }
    };

    const nextPage = async () => {
        currentPage.value++;
        await carService.getCarCollection({page: currentPage.value}).then(response => {
            cars.value = response;
            loading.value = false;
        }).catch(error => {
            console.log(error)
        })
    };

    const previousPage = async () => {
        if(currentPage.value > 1) {
            currentPage.value--;
            await getAxiosInstance().get('/cars?page='+currentPage.value)
                .then(response => {
                    cars.value = response.data;
                    loading.value = false;
                })
                .catch(error => {
                    console.log(error)
                });
        }
    };

    const nextPage = async () => {
        currentPage.value++;
        await getAxiosInstance().get('/cars?page='+currentPage.value)
            .then(response => {
                cars.value = response.data;
                loading.value = false;
            })
            .catch(error => {
                console.log(error)
            });
    };
</script>

<template>
    <div class="bg-gray-200 p-4 text-black">
      <h1 class="text-2xl font-medium">Admin Panel</h1>
      <h2 class="text-xl font-medium">Cars</h2>
      <button class="bg-blue-500 text-black px-4 py-2 rounded-lg">Create Car</button>
      <table class="w-full text-sm bg-white rounded-lg">
        <tr class="border-b">
            <th class="text-left p-3">Id</th>
            <th class="text-left p-3">Brand</th>
            <th class="text-left p-3">Model</th>
            <th class="text-left p-3">Price</th>
            <th class="text-left p-3">Year</th>
            <th class="text-left p-3">Fuel</th>
            <th class="text-left p-3">Kilometers</th>
            <th class="text-left p-3">Image</th>
            <th class="text-left p-3">Actions</th>
        </tr>
        <tr v-for="car in cars" :key="car.id" class="border-b hover:bg-gray-100">
            <th class="text-left p-3">{{ car.id }}</th>
            <td class="text-left p-3">BMW {{ car.identity.name }}</td>
            <td class="text-left p-3">{{ car.identity.category.name }}</td>
            <td class="text-left p-3">{{ car.price }}</td>
            <td class="text
            -left p-3">{{ car.year }}</td>
            <td class="text-left p-3">{{ car.fuel }}</td>
            <td class="text-left p-3">{{ car.mileage }}</td>
            <td class="text-left p-3">
            <img :src="car.images[0].src" width="150">
            </td>
            <td class="text-left p-3">
            <button class="bg-blue-500 text-white px-2 py-1 rounded-lg">Edit</button>
            <button class="bg-red-500 text-white px-2 py-1 rounded-lg" @click="deleteCar(car.id)">Delete</button>
            </td>
            </tr>
        </table>
        <div class="flex justify-between">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg" @click="previousPage">Previous</button>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg" @click="nextPage">Next</button>
        </div>
    </div>
</template>
