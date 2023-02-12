<script setup>
import {ref} from "vue";
import {CurrencyEuroIcon, FunnelIcon, CalendarIcon, BoltIcon, ScaleIcon, Battery50Icon, RocketLaunchIcon, ArrowRightIcon, ArrowLeftIcon, ShoppingCartIcon} from "@heroicons/vue/24/outline";
import orderService from "../../services/order.service";
import userService from "../../services/user.service";
import {useRouter} from "vue-router";
import CarListItemDetails from "./CarListItemDetails.vue";

const props = defineProps({
  car: {
    type: Object,
    required: true,
  },
  onlyShow: {
    type: Boolean,
    required: false,
    default: false,
  }
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
  await router.push({name: 'UserOrders', params: {slug: 'in-progress'}});
};

</script>

<template>
  <div class="max-w-sm max-h-[600px] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div v-show="!isDetailedShow">
      <img class="rounded-t-lg w-50 h-40" :src="car.identity.mainPicture.src" alt="" />
      <div class="p-5">
        <a href="#">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">BMW {{ car.identity.name }}</h5>
          <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-400 capitalize">{{ car.identity.category.name }}</p>
        </a>
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>

        <div class="flex justify-around items-center justify-center md:flex-row sm:flex-col">
          <button
              class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              @click="isDetailedShow = !isDetailedShow"
          >
            Voir le détail
            <ArrowRightIcon class="w-5 h-5 ml-2 -mr-1" />
          </button>

          <button v-if="!car.isOrdered && !onlyShow"
              class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-700 dark:hover:bg-green-500 dark:focus:ring-green-300"
              @click="handleOrder"
          >
            Commander
            <ShoppingCartIcon class="w-5 h-5 ml-2 -mr-1" />
          </button>
        </div>
      </div>
    </div>

    <div v-show="isDetailedShow">
      <!-- <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Default</span> -->
      <!-- svg cross -->
      <img class="rounded-t-lg w-50 h-40" :src="car.identity.mainPicture.src" alt="" />
      <div class="p-5">
        <CarListItemDetails :options="car.options" :details="[
            {icon: CalendarIcon, value: car.year},
            {icon: CurrencyEuroIcon, value: car.price, unit: '€'},
            {icon: FunnelIcon, value: car.fuel},
            {icon: BoltIcon, value: car.power, unit: 'ch'},
            {icon: ScaleIcon, value: car.weight, unit: 'kg'},
            {icon: Battery50Icon, value: car.consumption, unit: 'l/100km'},
            {icon: RocketLaunchIcon, value: car.speeding, unit: 's 0-100 km/h'}
          ]" />
        <button
            class="inline-flex items-center text-sm font-medium text-center text-white bg-white/10 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-white/10 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            @click="isDetailedShow = !isDetailedShow"
        >
          Retour
          <ArrowLeftIcon class="w-5 h-5 ml-2 -mr-1" />
        </button>
      </div>
    </div>

  </div>
</template>


<style scoped>

</style>