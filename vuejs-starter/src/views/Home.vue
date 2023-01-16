<script setup>
import { useStore } from "vuex";
import Navbar from "../components/Navbar.vue";

const store = useStore();
</script>

<template>
  <div class="w-full h-screen">
    <header class="h-[70vh] bg-[url('/public/bg_header.jpg')] bg-cover">
      <Navbar />
      <h1 class="uppercase text-3xl ml-24 mt-5 font-extrabold tracking-wider">Achat de véhicules neuf ou d'occasion</h1>
    </header>
  </div>
</template>