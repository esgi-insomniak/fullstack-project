<script setup>
import CarListItem from "./CarListItem.vue";

const props = defineProps({
  cars: {
    type: Array,
    required: true,
  }
});
</script>

<template>
  <div class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-2 xs:grid-cols-1 gap-4 py-4">
    <CarListItem v-for="car in cars" :car="car" />
  </div>
</template>

<style scoped>

</style>