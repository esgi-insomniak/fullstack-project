<script setup>
import Navbar from './components/Navbar.vue';
import VueJwtDecode from 'vue-jwt-decode'
import { useStore } from 'vuex';
const jwt_token = JSON.parse(localStorage.getItem('user')) ?? null;
const decoded = jwt_token ? VueJwtDecode.decode(jwt_token.token) : null;
const store = useStore()
if (decoded) store.commit('auth/loginSuccess', decoded)

</script>

<template>
  <Navbar />
  <main>
    <router-view />
  </main>
</template>
