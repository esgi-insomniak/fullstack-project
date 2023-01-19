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
  import axios from 'axios';
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
        successURL: 'http://localhost:8080/success',
        cancelURL: 'http://localhost:8080/cancel',
      };
    },
    mounted() {
      axios.post(`https://localhost/order/3/payment`)
        .then(response => {
          console.log(response.data.price);
          //this.lineItems[0].price = response.data.price;
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