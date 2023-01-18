<script setup>
import { ref, computed, onMounted } from 'vue'
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const props = defineProps({
  email: {
    type: String,
  },
  password: {
    type: String,
  }
})

const email = ref('')
const password = ref('')
const store = useStore();
const router = useRouter();

const isDisabled = computed(() => {
  return email.value.length === 0 || password.value.length === 0
});

const loggedIn = computed(() => {
  return store.getters['auth/loggedIn'];
});

const handleLogin = () => {
  store.dispatch('auth/login', { email: email.value, password: password.value }).then(() => {
    router.push('/home');
  })
    .catch((error) => {
      console.log(error);
    });
}

onMounted(() => {
  if (loggedIn.value) {
    router.push('/home');
  }
});

</script>

<template>
  <div class="flex justify-center items-center h-screen">
    <div class="w-2/3 h-4/6 rounded-3xl shadow-md bg-white/30 flex">
      <div class="w-1/3 flex flex-col justify-center items-center px-2">
        <FormKit type="form" form-class="w-full flex justify-center  flex-col h-4/6" @submit="handleLogin"
          submit-label="Connexion">
          <FormKit type="text" name="email" label="Email" placeholder="exemple@email.here" validation="required|email"
            v-model="email" />
          <FormKit type="password" name="password" label="Password" placeholder="Mot de passe"
            validation="required|password" v-model="password" />
        </FormKit>
        <div class="h-1/6 w-full mt-10" />
      </div>
      <div class="w-1/3 flex flex-col justify-end items-end">
        <div class="p-3 rounded-lg bg-green-400 mb-10 -mr-7 hover:cursor-pointer hover:bg-green-500">
          Créer un compte
        </div>
      </div>
    </div>
  </div>
</template>