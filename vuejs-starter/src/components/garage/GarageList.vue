<script setup>
import GarageListItem from "./GarageListItem.vue";
import {computed, ref} from "vue";

const props = defineProps({
  garages: {
    type: Array,
    required: true,
  },
  search: {
    type: Boolean,
    required: true,
  },
});

const searchInput = ref(null);

const filteredGarages = computed(() => {
  if (!searchInput.value) return props.garages;
  return props.garages.filter(garage => {
    return garage.name.toLowerCase().includes(searchInput.value.toLowerCase());
  });
});



const scrollToSelectedGarage = (el) => {
  if (!el || !el instanceof HTMLElement) return;
  el.scrollIntoView({ behavior: 'smooth', block: 'center' });
};

const emits = defineEmits(['garage-click']);
</script>

<template>
  <div>
    <div class="mx-3">
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Garages</h2>
      <input
          v-if="search"
          type="text"
          class="w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 focus:outline-none focus:shadow-outline"
          placeholder="Rechercher"
          v-model="searchInput"
      />
    </div>
    <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 max-h-[500px] overflow-auto scrollbar-hide">
      <li
          class="p-3 sm:p-4 hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer"
          v-for="garage in filteredGarages"
          :key="garage.id"
          :class="{'bg-gray-50 dark:bg-gray-800': garage.selected}"
          :data-selected="garage.selected"
          :ref="el => (garage.selected) ? scrollToSelectedGarage(el) : null"
          @click="emits('garage-click', garage)"
      >
        <garage-list-item :garage="garage" />
      </li>
    </ul>
  </div>
</template>

<style scoped>

</style>