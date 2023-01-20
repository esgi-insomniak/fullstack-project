<template>
    <div>
      <stripe-checkout
        ref="checkoutRef"
        mode="payment"
        :pk="publishableKey"
        :line-items="lineItems"
        :success-url="successURL"
        :cancel-url="cancelURL"
        @loading="v => loading = v"
      />
      <button @click="submit">Pay now!</button>
    </div>
  </template>
  
  <script>
  import { StripeCheckout } from '@vue-stripe/vue-stripe';
  import {getAxiosInstance} from "../../helpers/axios/config.js";

  export default {
    components: {
      StripeCheckout,
    },
    data () {
      this.publishableKey = "pk_test_51MRXR1KanJPVHpR6ajE7MCpymd1qd5FRXgfkeS7MP2mIeZiMXvWlarpNrbL0hqznLoHc9FN5wV893HsHEnWOlSfo00X91Qetbx";
      return {
        loading: false,
        lineItems: [
          {
            price: null,
            quantity: 1,
          },
        ],
        successURL: 'http://localhost:8080/success?session_id={CHECKOUT_SESSION_ID}',
        cancelURL: 'http://localhost:8080/cancel',
      };
    },
    mounted() {
      getAxiosInstance().post(`https://localhost/payment/1004`)
        .then(response => {
          console.log(response.data.price);
          this.lineItems[0].price = response.data.price;
        })
        .catch(error => {
          console.log(error)
        });
    },
  methods: {
    submit () {
      this.$refs.checkoutRef.redirectToCheckout();
    },
  },
};
</script>