<script setup>
import { onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import orderService from '../../../services/order.service';

const router = useRouter();
const route = useRoute();
const { orderId, sessionId } = route.params;

onMounted(() => {
  orderService.postOrderPaymentValidation(orderId, sessionId).catch(() => { });
  setTimeout(() => {
    router.push({ name: 'UserOrders', params: { slug: 'in-progress' } });
  }, 3000);
});
</script>

<template>
  <div class="w-full h-screen min-w-[500px] flex items-center justify-between flex-col">
    <div class="h-1/4 w-full" />
    <div class="p-6 md:mx-auto rounded-lg bg-white/20 shadow-inner shadow-slate-200">
      <svg viewBox="0 0 24 24" class="text-green-600 w-16 h-16 mx-auto my-6">
        <path fill="currentColor"
          d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z">
        </path>
      </svg>
      <div class="text-center">
        <h3 class="md:text-2xl text-base text-white font-semibold text-center">Payement validé !</h3>
        <p class="text-white my-2">Merci pour votre achat.</p>
        <p class="text-white my-2">Vous allez être redirigé dans quelques instants</p>
      </div>
    </div>
    <div class="h-full w-full" />
  </div>
</template>