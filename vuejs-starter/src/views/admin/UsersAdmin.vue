<script setup>
import {
    ref,
    onMounted
} from 'vue';
import userService from "../../services/user.service";
import { UserPlusIcon, ChevronLeftIcon, ChevronRightIcon, TrashIcon, PencilSquareIcon } from '@heroicons/vue/24/outline';

const users = ref([]);
const loading = ref(true);
const currentPage = ref(1);
const thead = ref([{
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
]);

onMounted(async () => {
    users.value = await userService.getCollection({
        page: currentPage.value
    });
    loading.value = false;
});
console.log(users);
const editUser = (id) => {
    console.log('edit user', id);
};

const deleteUser = async (id) => {
    await userService.delete(id).then(response => {
        console.log(response);
    }).catch(error => {
        alert('L\'utilisateur ne peut être supprimer, il est lié à une commande')
        console.log(error)
    });
};

const createUser = () => {
    console.log('create user');
};

const previousPage = async () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        await userService.getCollection({
            page: currentPage.value
        }).then(response => {
            users.value = response;
            loading.value = false;
        }).catch(error => {
            console.log(error)
        });
    }
};

const nextPage = async () => {
    currentPage.value++;
    await userService.getCollection({
        page: currentPage.value
    }).then(response => {
        users.value = response;
        loading.value = false;
        if (users.value.length === 0) {
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
    <h2 class="text-2xl uppercase tracking-widest">Utilisateur</h2>
    <button class="flex items-center justify-center min-w-[15rem]" @click="openModal">Ajouter un utilisateur<UserPlusIcon class="h-5 w-5 ml-3" /></button>
</div>
    <table class="table-auto w-full mx-auto text-left my-5">
        <tr>
            <th class="p-3" v-for="column in thead" :key="column.id">{{ column.label }}</th>
        </tr>
        <tr v-for="(user, index) in users" :key="user.id" :class="{'bg-gray-400': index % 2 === 0, 'text-black': index % 2 === 0}">
            <td class="p-3">{{ user.id }}</td>
            <td class="py-3">{{ user.firstName }}</td>
            <td class="py-3">{{ user.lastName }}</td>
            <td class="py-3">{{ user.email }}</td>
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
