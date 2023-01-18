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
            price: 'price_1MRXUnKanJPVHpR6gKDgqaQL',
            quantity: 1,
          },
        ],
        successURL: 'http://localhost:8080/success',
        cancelURL: 'http://localhost:8080/cancel',
      };
    },
    methods: {
      submit () {
        this.$refs.checkoutRef.redirectToCheckout();
      },
    },
  };
  </script>