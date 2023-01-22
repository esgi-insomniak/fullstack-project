<script setup>
import { ref, onMounted, computed } from 'vue'
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const router = useRouter();

const recoveryToken = router.currentRoute.value.params.token;

const password = ref('')
const confirmPassword = ref('')

const submitForm = () => {
    if (password.value !== confirmPassword.value) {
        return;
    }

    store.dispatch('auth/accountRecovery', { recoveryToken: recoveryToken, password: password.value, confirmPassword: confirmPassword.value }).then(() => {
        router.push('/login');
    })
        .catch((error) => {
            console.log(error);
        });
}

const loggedIn = computed(() => {
    return store.getters['auth/loggedIn'];
});

onMounted(() => {
    if (loggedIn.value) {
        router.push('/home');
    }
});

</script>

<template>
    <div class="flex justify-center items-center h-screen">
        <div class="w-2/3 max-w-[600px] rounded-3xl shadow-md bg-white/30 flex">
            <div class="w-full p-10">
                <FormKit type="form" form-class="w-full" @submit="submitForm" :actions="false" #default="{ disabled }">
                    <FormKit type="password" name="password" label="Mot de passe" placeholder="Mot de passe"
                        validation="required|password" v-model="password" />
                    <FormKit type="password" name="confirmPassword" label="Confirmation du mot de passe"
                        placeholder="Mot de passe" validation="required|password" v-model="confirmPassword" />
                    <p v-if="confirmPassword != '' && password !== confirmPassword" class="text-red-500">Les mots de
                        passe ne correspondent pas.
                    </p>
                    <div class="text-center w-full">
                        <button slot="submit"
                            :class="{ 'bg-gray-500': confirmPassword === '' || password !== confirmPassword, 'bg-indigo-500': confirmPassword !== '' && password === confirmPassword }"
                            :disabled="confirmPassword === '' || password !== confirmPassword"
                            class="w-4/6 px-4 py-2 text-white rounded-lg text-lg hover:bg-indigo-600">Réinitialiser mon
                            mot de
                            passe</button>
                    </div>
                </FormKit>
            </div>
        </div>
    </div>
</template>