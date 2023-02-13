<script setup>
import {
    ref,
    onMounted,
    reactive
} from 'vue';
import userService from "../../services/user.service";
import { UserPlusIcon, ChevronLeftIcon, ChevronRightIcon, TrashIcon, PencilSquareIcon } from '@heroicons/vue/24/outline';
import Modal from "../../components/Modal.vue";
import Map from "../../components/Map.vue";

const users = ref([]);
const loading = ref(true);
const currentPage = ref(1);
const myUser = ref({})
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

const editUser = async (user) => {
    await userService.patch(user.id, user).then(user => {
      users.value = users.value.map((u) => {
        if (u.id === user.id) {
          u = user;
        }
        return u;
    });
        toggleModal();
    }).catch(error => {
        console.log(error)
    });
};

const deleteUser = async (user) => {
    await userService.delete(user.id).then(response => {
        users.value = users.value.filter((u) => u.id !== user.id);
        toggleModal();
    }).catch(error => {
        console.log(error)
    });
};

const loadModificationModal = async (user) => {
    myUser.value = await userService.get(user.id);
    modalProps.id = 'modification';
    modalProps.title = `Modification de l'utilisateur ${user.firstName} ${user.lastName}`;
    modalProps.content = 'Voulez-vous vraiment modifier cet utilisateur ?';
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
            action: async () => editUser(myUser.value)
        }
    ]
    toggleModal();
}

const loadDeleteModal = async (user) => {
    myUser.value = await userService.get(user.id);
    modalProps.id = 'delete';
    modalProps.title = `Suppression de l'utilisateur ${user.firstName} ${user.lastName}`;
    modalProps.content = 'Voulez-vous vraiment supprimer cet utilisateur ?';
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
            action: async () => deleteUser(myUser.value)
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
              <label class="text-sm font-medium text-gray-700">Prénom</label>
              <input v-model="myUser.firstName" type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

              <label class="text-sm font-medium text-gray-700">Nom</label>
              <input v-model="myUser.lastName" type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

              <label class="text-sm font-medium text-gray-700">Email</label>
              <input v-model="myUser.email" type="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>
      </div>
  </Modal>
<div class="h-[75vh] overflow-scroll scrollbar-hide">
    <div class="flex justify-between w-full">
    <h2 class="text-2xl uppercase tracking-widest">Utilisateur</h2>
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
                <button v-on:click="loadModificationModal(user)" class="mr-3 flex items-center justify-center min-w-[8rem]">Modifier <PencilSquareIcon class="h-5 w-5 ml-3" /></button>
                <button class="ml-3 flex items-center justify-center min-w-[8rem]" v-on:click="loadDeleteModal(user)">Supprimer <TrashIcon class="h-5 w-5 ml-3" /></button>
            </td>
        </tr>
    </table>
</div>
<div class="flex justify-end my-5 space-x-3">
    <button @click="previousPage" class="bg-blue-900 min-w-[10rem]"><ChevronLeftIcon  class="h-7 w-7 mx-auto" /></button>
    <button @click="nextPage" class="bg-blue-900 min-w-[10rem]"><ChevronRightIcon  class="h-7 w-7 mx-auto" /></button>
</div>
</template>
