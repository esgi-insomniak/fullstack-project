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
});
</script>

<template>
  <div class="grid grid-cols-4 gap-4 py-4">
    <CarListItem v-for="car in cars" :car="car" />
  </div>
</template>

<style scoped>

</style>