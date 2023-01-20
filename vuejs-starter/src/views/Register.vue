<script setup>

import {ref, computed, onMounted} from 'vue'
import {useStore} from "vuex";
import {useRouter} from "vue-router";

const formData = ref({
  email: '',
  plainPassword: '',
  confirmPassword: '',
  firstName: '',
  lastName: '',
  coordinates: []
})

const store = useStore();
const router = useRouter();

onMounted(() => {
  if (store.getters['auth/loggedIn']) {
    router.push('/home');
  }
});

const handleRegister = (form) => {
  console.log(form);
  if (form.plainPassword !== form.confirmPassword) {
    this.error = 'Les mots de passe ne correspondent pas';
    return;
  }
  store.dispatch('auth/register', form)
    .then(() => {
      router.push('/login');
    })
    .catch((error) => {
      this.error = error;
    });
}

</script>

<template>
  <div class="flex justify-center items-center h-screen">
    <div class="w-2/3 h-4/6 rounded-3xl shadow-md bg-white/30 flex">
      <div class="w-1/3 flex flex-col justify-center items-center px-2">
        <FormKit
            type="form"
            form-class="w-full flex justify-center flex-col h-4/6"
            @submit="handleRegister"
            v-model="formData"
            submit-label="Créer mon compte"
        >
          <FormKit
              type="text"
              name="email"
              label="Email"
              placeholder="exemple@email.here"
              validation="required|email"
          />
          <FormKit
              type="text"
              name="firstName"
              label="Prénom"
              placeholder="Michel"
              validation="required|alpha"
          />
          <FormKit
              type="text"
              name="lastName"
              label="Nom"
              placeholder="Dupont"
              validation="required|alpha"
          />
          <FormKit
              type="password"
              name="plainPassword"
              label="Password"
              placeholder="Mot de passe"
              validation="required|password"
          />
          <FormKit
              type="password"
              name="confirmPassword"
              label="Password Confirmation"
              placeholder="Mot de passe"
              validation="required|password"
          />
        </FormKit>
        <div class="h-1/6 w-full mt-10" />
      </div>
    </div>
  </div>
</template>