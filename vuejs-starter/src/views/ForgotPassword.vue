<script setup>
import { ref, onMounted, computed } from 'vue'
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const router = useRouter();

const email = ref('')

const submitForm = () => {
    store.dispatch('auth/forgotPassword', { email: email.value }).then(() => {
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
                <FormKit type="form" form-class="w-full" @submit="submitForm" submit-label="Envoyer">
                    <FormKit type="text" name="email" label="Email" placeholder="exemple@email.here"
                        validation="required|email" v-model="email" />
                </FormKit>
            </div>
        </div>
    </div>
</template>