<script setup>

import { ref, onMounted } from 'vue'
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const router = useRouter();

const newUser = ref({
  firstName: '',
  lastName: '',
  email: '',
  plainPassword: '',
  confirmPassword: '',
})

const messError = ref('');
const messSuccess = ref('');

onMounted(() => {
  if (store.getters['auth/loggedIn']) {
    router.push('/home');
  }
});

const handleRegister = (user) => {
  if (user.plainPassword !== user.confirmPassword) {
    messError.value = 'Les mots de passe ne correspondent pas';
    setTimeout(() => {
      messError.value = '';
    }, 3000);
    return;
  } else {
    store.dispatch('auth/register', user)
      .then(() => {
        setTimeout(() => {
          messSuccess.value = 'Votre compte a bien été créé ✅';
          router.push('/login');
        }, 3000);
      })
      .catch((err) => {
        messError.value = err;
        setTimeout(() => {
          messError.value = '';
        }, 3000);
      });
  }
}

</script>

<template>
  <div class="flex justify-center items-center h-[88vh]">
    <div class="w-3/4 h-5/6 rounded-3xl shadow-md bg-white/30 flex divide-x">
      <div class="w-1/3 bg-[url('/public/bg_register.jpg')] bg-cover rounded-l-3xl" />
      <div class="w-2/3 p-5 flex jusitfy-center items-center h-full flex-col">
        <FormKit type="form" form-class="grid grid-flow-row grid-cols-2 gap-2 w-full" @submit="handleRegister"
          submit-label="Créer mon compte" v-model="newUser">
          <FormKit type="text" name="firstName" label="Prénom" placeholder="Karl" validation="required|alpha" />
          <FormKit type="text" name="lastName" label="Nom" placeholder="Marques" validation="required|alpha" />
          <FormKit type="text" name="email" label="Email" placeholder="exemple@email.here"
            validation="required|email" />
          <FormKit type="password" name="plainPassword" label="Password" placeholder="Mot de passe"
            validation="required|password" />
          <FormKit type="password" name="confirmPassword" label="Password Confirmation" placeholder="Mot de passe"
            validation="required|password" />
        </FormKit>
        <span class="text-red-500 italic font-bold">{{ messError !== '' ? messError : null }}</span>
        <span class="text-green-500 italic font-bold">{{ messSuccess !== '' ? messSuccess : null }}</span>
      </div>
    </div>
  </div>
</template>