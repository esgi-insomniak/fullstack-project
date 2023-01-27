<script setup>
import {getAxiosInstance} from "../../helpers/axios/config.js";
import { ref, onMounted } from 'vue';

const users = ref([]);
const loading = ref(true);
const currentPage = ref(1);

onMounted(async () => {
    await getAxiosInstance().get('/users?page='+currentPage.value)
        .then(response => {
            users.value = response.data;
            loading.value = false;
        })
        .catch(error => {
            console.log(error)
        });
});
console.log(users);
const editUser = (id) => {
  console.log('edit user', id);
};

const deleteUser = async (id) => {
  await getAxiosInstance().delete('/users/' + id)
      .then(response => {
          console.log(response);
      })
      .catch(error => {
          alert('L\'utilisateur ne peut être supprimer, il est lié à une commande')
          console.log(error)
      });
};

const createUser = () => {
  console.log('create user');
};

const previousPage = async () => {
    if(currentPage.value > 1) {
        currentPage.value--;
        await getAxiosInstance().get('/users?page='+currentPage.value)
            .then(response => {
                users.value = response.data;
                loading.value = false;
            })
            .catch(error => {
                console.log(error)
            });
    }
};

const nextPage = async () => {
    currentPage.value++;
    await getAxiosInstance().get('/users?page='+currentPage.value)
        .then(response => {
            users.value = response.data;
            loading.value = false;
        })
        .catch(error => {
            console.log(error)
        });
};
</script>

<template>
    <div>
      <h1>Admin Panel</h1>
      <h2>Users</h2>
      <button @click="openModal">Create User</button>
      <table>
        <tr>
          <th>ID</th>
          <th>Prenom</th>
          <th>Nom</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.firstName }}</td>
            <td>{{ user.lastName }}</td>
          <td>{{ user.email }}</td>
          <td>
            <button @click="editUser(user.id)">Edit</button>
            <button @click="deleteUser(user.id)">Delete</button>
          </td>
        </tr>
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

  