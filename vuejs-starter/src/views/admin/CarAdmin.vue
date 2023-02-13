<script setup>
import {
    ref,
    onMounted,
    reactive
} from 'vue';
import carService from "../../services/car.service";
import {
    UserPlusIcon,
    ChevronLeftIcon,
    ChevronRightIcon,
    TrashIcon,
    PencilSquareIcon,
    PlusCircleIcon
} from '@heroicons/vue/24/outline';
import Modal from "../../components/Modal.vue";

const cars = ref([]);
const loading = ref(true);
const myCar = ref({})
const currentPage = ref(1);
const thead = [{
        id: 'id',
        label: 'ID'
    },
    {
        id: 'brand',
        label: 'Marque'
    },
    {
        id: 'model',
        label: 'Modèle'
    },
    {
        id: 'price',
        label: 'Prix'
    },
    {
        id: 'year',
        label: 'Année'
    },
    {
        id: 'fuel',
        label: 'Carburant'
    },
    {
        id: 'kilometers',
        label: 'Kilométrage'
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
    cars.value = await carService.getCarCollection({
        page: currentPage.value
    });
    loading.value = false;
});

const previousPage = async () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        await getAxiosInstance().get('/cars?page=' + currentPage.value)
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
    await getAxiosInstance().get('/cars?page=' + currentPage.value)
        .then(response => {
            cars.value = response.data;
            loading.value = false;
        })
        .catch(error => {
            console.log(error)
        });
};

const editCar = async (car) => {
    await carService.patchCar(car.id, car).then(car => {
      cars.value = cars.value.map((c) => {
        if (c.id === car.id) {
          c = car;
        }
        return c;
    });
        toggleModal();
    }).catch(error => {
        console.log(error)
    });
};

const deleteCar = async (car) => {
    await carService.deleteCar(car.id).then(response => {
        cars.value = cars.value.filter((c) => c.id !== car.id);
        toggleModal();
    }).catch(error => {
        console.log(error)
    });
};

const addCar = async (car) => {
    await carService.postCar(car).then(car => {
        cars.value.push(car);
        toggleModal();
    }).catch(error => {
        console.log(error)
    });
};

const loadModificationModal = async (car) => {
    console.log(car)
    myCar.value = await carService.getCar(car.id);
    modalProps.id = 'modification';
    modalProps.title = `Modification de la voiture ${myCar.value.brand} ${myCar.value.model}`;
    modalProps.content = 'Modification de la voiture'
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
            action: async () => editCar(myCar.value)
        }
    ]
    toggleModal();
}

const loadDeleteModal = async (car) => {
    myCar.value = await carService.getCar(car.id);
    modalProps.id = 'delete';
    modalProps.title = `Suppression de la voiture ${myCar.value.brand} ${myCar.value.model}`;
    modalProps.content = 'Voulez-vous vraiment supprimer cet voiture ?';
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
            action: async () => deleteCar(myCar.value)
        }
    ]
    toggleModal();
}

const loadAddModal = async () => {
    myCar.value = {
        brand: '',
        model: '',
        image: ''
    };
    modalProps.id = 'add';
    modalProps.title = `Ajout d'une voiture`;
    modalProps.content = 'Ajout d\'une voiture';
    modalProps.icon = {
        type: PlusCircleIcon,
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
            text: 'Ajouter',
            class: 'inline-flex w-full justify-center rounded-md border border-transparent px-4 py-2 text-base font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm bg-green-600 hover:bg-green-700 focus:ring-green-500',
            action: async () => addCar(myCar.value)
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
                <label class="block text-sm font-medium text-gray-700">Prix</label>
                <input type="number" v-model="myCar.price" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            
                <label class="block text-sm font-medium text-gray-700">Année</label>
                <input type="text" v-model="myCar.year" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                <label class="block text-sm font-medium text-gray-700">Fuel</label>
                <input type="text" v-model="myCar.fuel" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                <label class="block text-sm font-medium text-gray-700">Kilométrage</label>
                <input type="number" v-model="myCar.mileage" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
        </div>
        <div v-else>
            <div class="flex flex-col">
                <label class="block text-sm font-medium text-gray-700">Prix</label>
                <input type="number" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            
                <label class="block text-sm font-medium text-gray-700">Année</label>
                <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                <label class="block text-sm font-medium text-gray-700">Fuel</label>
                <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                <label class="block text-sm font-medium text-gray-700">Kilométrage</label>
                <input type="number" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
        </div>
    </Modal>
<div class="h-[75vh] overflow-scroll scrollbar-hide">
    <div class="flex justify-between w-full">
        <h2 class="text-2xl uppercase tracking-widest">Voitures</h2>
        <button class="flex items-center justify-center min-w-[15rem]" @click="loadAddModal()">Ajouter une voiture
            <PlusCircleIcon class="w-5 h-5 ml-3" /></button>
    </div>
    <table class="table-auto w-full mx-auto text-left my-5">
        <tr>
            <th class="p-3" v-for="column in thead" :key="column.id">{{ column.label }}</th>
        </tr>
        <tr v-for="(car, index) in cars" :key="car.id" :class="{'bg-gray-400': index % 2 === 0, 'text-black': index % 2 === 0}">
            <td class="p-3">{{ car.id }}</td>
            <td class="py-3">BMW {{ car.identity.name }}</td>
            <td class="py-3">{{ car.identity.category.name }}</td>
            <td class="py-3">{{ car.price }}</td>
            <td class="py-3">{{ car.year }}</td>
            <td class="py-3">{{ car.fuel }}</td>
            <td class="py-3">{{ car.mileage }}</td>
            <td class="py-3">
                <img :src="car.images[0].src" width="150">
            </td>
            <td class="py-10 flex" :class="{'text-white': index % 2 === 0}">
                <button class="mr-3 flex items-center justify-center min-w-[8rem]" @click="loadModificationModal(car)">Modifier
                    <PencilSquareIcon class="h-5 w-5 ml-3" /></button>
                <button @click="loadDeleteModal(car)" class="ml-3 flex items-center justify-center min-w-[8rem]">Supprimer
                    <TrashIcon class="h-5 w-5 ml-3" /></button>
            </td>
        </tr>
    </table>
</div>
<div class="flex justify-end my-5 space-x-3">
    <button @click="previousPage" class="bg-blue-900 min-w-[10rem]"><ChevronLeftIcon class="h-7 w-7 mx-auto" /></button>
    <button @click="nextPage" class="bg-blue-900 min-w-[10rem]"><ChevronRightIcon class="h-7 w-7 mx-auto" /></button>
</div>
</template>
