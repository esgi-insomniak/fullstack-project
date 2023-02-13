<script setup>
import CarListItem from "./CarListItem.vue";

const props = defineProps({
  cars: {
    type: Array,
    required: true,
  },
  search: {
    type: Boolean,
    required: true,
  },
  user: {
    type: Object,
    required: false,
  }
});
</script>

<template>
  <div class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-2 xs:grid-cols-1 gap-4 py-4">
    <CarListItem v-for="car in cars" :car="car" :user="user"/>
  </div>
</template>

<style scoped>

</style>