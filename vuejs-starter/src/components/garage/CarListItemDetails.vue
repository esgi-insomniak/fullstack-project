<script setup>
const props = defineProps({
  options: {
    type: Array,
    required: false,
  },
  details: {
    type: Array,
    required: false,
    default: () => {
      return [{
        icon: "mdi-car",
        value: "Car",
        unit: "",
      }];
    },
  },
});
</script>

<template>
  <div class="grid grid-cols-2 gap-4 text-xs">
    <ul class="mb-8 space-y-4 text-left text-gray-500 dark:text-gray-400" v-if="options.length > 0">
      <li class="flex items-center space-x-3" v-for="option in options">
        <!-- Icon -->
        <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
        <span>{{ option }}</span>
      </li>
    </ul>

    <ul class="mb-8 space-y-4 text-gray-500 dark:text-gray-400">
      <li class="flex items-center space-x-3" v-for="detail in details">
        <!-- Icon -->
        <component :is="detail.icon"  class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" />
        <span>{{ detail.value }} {{ detail.unit ?? "" }}</span>
      </li>
    </ul>
  </div>
</template>

<style scoped>

</style>