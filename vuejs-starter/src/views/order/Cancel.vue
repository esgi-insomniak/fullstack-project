<template>
    <div>
      <div v-if="isSuccess">
        <h1>Merci !</h1>
        <p>Votre paiement a été effectué avec succès.</p>
      </div>
      <div v-else-if="isCancel">
        <h1>Annulation</h1>
        <p>Votre paiement a été annulé.</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        isSuccess: false,
        isCancel: false
      }
    },
    created() {
      if (this.$route.name === 'success') {
        this.isSuccess = true;
      } else if (this.$route.name === 'cancel') {
        this.isCancel = true;
      }
    }
  }
  </script>
  