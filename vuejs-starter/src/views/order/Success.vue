<template>
    <div>
      <h1>Merci !</h1>
      <p>Votre paiement a été effectué avec succès.</p>
      <p>ID de la transaction : {{ transactionId }}</p>
      <p>Montant : {{ amount }} {{ currency }}</p>
    </div>
</template>
  
<script>
    import {loadStripe} from '@stripe/stripe-js';
  
    export default {
        data() {
            return {
                transactionId: null,
                amount: null,
                currency: null
            }
        },
        created() {
    // Récupérer l'ID de la transaction à partir de l'URL
            console.log(this.$route.query)
            this.transactionId = this.$route.query.transaction_id;

    // Charger Stripe.js
            const stripe = loadStripe("pk_test_51MRXR1KanJPVHpR6ajE7MCpymd1qd5FRXgfkeS7MP2mIeZiMXvWlarpNrbL0hqznLoHc9FN5wV893HsHEnWOlSfo00X91Qetbx");
            
            // Récupérer les informations de la transaction à partir de l'ID
            stripe.retrieveTransaction(this.transactionId).then(transaction => {
                this.amount = transaction.amount / 100;
                this.currency = transaction.currency;
            });
        }
    }
</script>