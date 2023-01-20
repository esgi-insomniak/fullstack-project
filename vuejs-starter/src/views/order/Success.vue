<template>
    <div>
      <h1>Payment Receipt</h1>
      <p>Transaction ID: {{ transactionId }}</p>
      <p>Amount: {{ amount }} {{ currency }}</p>
      <p>Payment status: {{ status }}</p>
    </div>
  </template>
  
<script>
    import {loadStripe} from '@stripe/stripe-js';
    import axios from 'axios';

    const urlParams = new URLSearchParams(window.location.search);
const sessionId = urlParams.get('session_id');
    export default {
        data() {
            return {
                transactionId: null,
                amount: null,
                currency: null,
                status: null,
            }
        },
        created() {
            axios.get(`https://api.stripe.com/v1/checkout/sessions/${sessionId}`, {
  headers: {
    'Authorization': `Bearer sk_test_51MRXR1KanJPVHpR6mu816wVhlqu7S1qte3mQLTwSS4OgUCWt4Qgezp9f6vCyGjZdHS0Z253Drt4NOMzurHb30zZ300QTIkmjpF`
  }
})
.then(response => {
  console.log(response.data);
    this.transactionId = response.data.id;
    this.amount = response.data.amount_total / 100;
    this.currency = response.data.currency;
    this.status = response.data.payment_status;
  // Use the data from the response to update your application
})
.catch(error => {
  console.log(error);
});
        }
    }
</script>