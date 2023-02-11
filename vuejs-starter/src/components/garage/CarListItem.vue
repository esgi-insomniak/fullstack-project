<script setup>
import {ref} from "vue";
import {CurrencyEuroIcon, FunnelIcon, CalendarIcon, BoltIcon, ScaleIcon, Battery50Icon, RocketLaunchIcon, ArrowRightIcon, ArrowLeftIcon, ShoppingCartIcon} from "@heroicons/vue/24/outline";
import orderService from "../../services/order.service";
import userService from "../../services/user.service";
import {useRouter} from "vue-router";

const props = defineProps({
  car: {
    type: Object,
    required: true,
  },
});

const router = useRouter();

const isDetailedShow = ref(false);

const handleOrder = async () => {
  const me = await userService.get('me');
  const order = {
    orderer: `users/${me.id}`,
    car: `cars/${props.car.id}`,
    garage: `garages/${props.car.garage.id}`,
    totalPrice: props.car.price,
  }
  await orderService.post(order);
  router.push({ name: 'UserOrders', params: { slug: 'in-progress' } });
};

</script>

<template>
  <div class="max-w-sm max-h-[600px] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

    <div v-if="!isDetailedShow">
      <img class="rounded-t-lg" :src="car.identity.mainPicture.src" alt="" />
      <div class="p-5">
        <a href="#">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">BMW {{ car.identity.name }}</h5>
          <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-400 text-capitalize">{{ car.identity.category.name }}</p>
        </a>
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>

        <div class="flex justify-around items-center justify-center">
          <button
              class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              @click="isDetailedShow = !isDetailedShow"
          >
            Voir le détail
            <ArrowRightIcon class="w-5 h-5 ml-2 -mr-1" />
          </button>

          <button
              class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-700 dark:hover:bg-green-500 dark:focus:ring-green-300"
              @click="handleOrder"
          >
            Commander
            <ShoppingCartIcon class="w-5 h-5 ml-2 -mr-1" />
          </button>
        </div>
      </div>
    </div>
    <Transition>
    <div v-if="isDetailedShow">
      <!-- <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Default</span> -->
      <!-- svg cross -->
      <img class="rounded-t-lg" :src="car.identity.mainPicture.src" alt="" />
      <div class="p-5">

        <div class="grid grid-cols-2 gap-4 text-xs">
          <ul class="mb-8 space-y-4 text-left text-gray-500 dark:text-gray-400" v-if="car.options.length > 0">
            <li class="flex items-center space-x-3" v-for="option in car.options">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
              <span>{{ option }}</span>
            </li>
          </ul>

          <ul class="mb-8 space-y-4 text-gray-500 dark:text-gray-400" v-if="car.options.length > 0">
            <li class="flex items-center space-x-3">
              <CalendarIcon class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" />
              <span>{{ car.year }}</span>
            </li>

            <li class="flex items-center space-x-3">
              <CurrencyEuroIcon class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" />
              <span>{{ car.price }} €</span>
            </li>

            <li class="flex items-center space-x-3">
              <FunnelIcon class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" />
              <span>{{ car.fuel }}</span>
            </li>

            <li class="flex items-center space-x-3">
              <BoltIcon class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" />
              <span>{{ car.power }} ch</span>
            </li>

            <li class="flex items-center space-x-3">
              <ScaleIcon class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" />
              <span>{{ car.weight }} kg</span>
            </li>

            <li class="flex items-center space-x-3">
              <Battery50Icon class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" />
              <span>{{ car.consumption }} l/100km</span>
            </li>

            <li class="flex items-center space-x-3">
              <RocketLaunchIcon class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" />
              <span>{{ car.speeding }}s 0-100 km/h</span>
            </li>
          </ul>
        </div>

        <button
            class="inline-flex items-center text-sm font-medium text-center text-white bg-white/10 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-white/10 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            @click="isDetailedShow = !isDetailedShow"
        >
          Retour
          <ArrowLeftIcon class="w-5 h-5 ml-2 -mr-1" />
        </button>
      </div>
    </div>
    </Transition>
  </div>
</template>


<style scoped>

</style>