<script setup>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const store = useStore();
const router = useRouter();
onMounted(() => {
    store.dispatch('auth/logout')
    router.push('/')
})
</script>