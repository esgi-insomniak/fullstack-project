<script setup>
import {useStore} from "vuex";

const store = useStore();
</script>

<template>
    <div class="w-full h-screen">
      <h1 class="text-green-400">Home</h1>
      <button
          class="bg-green-400 text-white px-4 py-2 rounded"
          v-if="store.getters['auth/isLoggedIn']"
          @click="store.dispatch('auth/logout')"
      >Logout</button>
    </div>
</template>