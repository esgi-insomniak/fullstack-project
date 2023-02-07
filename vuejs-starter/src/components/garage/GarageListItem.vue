<script setup>
const props = defineProps({
  garage: {
    type: Object,
    required: true,
    default: () => ({
      id: 1,
      name: 'Garage Flowbite',
      isOpen: true,
    }),
    validator(value) {
      return value.id && value.name && value.isOpen;
    }
  }
});
</script>
<template>
  <div class="flex items-center space-x-4">
    <div class="flex-shrink-0">
      <img class="w-8 h-8 rounded-full" src="/bmw_logo.png" :alt="garage.name">
    </div>
    <div class="flex-1 min-w-0">
      <p class="text-sm font-medium text-gray-900 truncate dark:text-white">{{ garage.name }}</p>
      <p class="text-sm text-gray-500 truncate dark:text-gray-400">email@flowbite.com</p>
    </div>
    <div
        class="inline-flex items-center text-base font-semibold"
        :class="{'text-green-500': garage.isOpen,'text-red-500': !garage.isOpen}"
        v-text="garage.isOpen ? 'OUVERT' : 'FERMÉ'"
    >
    </div>
  </div>
</template>

<style scoped>

</style>