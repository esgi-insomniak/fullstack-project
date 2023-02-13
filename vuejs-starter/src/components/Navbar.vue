<script setup>
import { useRoute } from 'vue-router';
import { UserIcon, MagnifyingGlassIcon, ShoppingCartIcon, ArrowLeftOnRectangleIcon, ArrowRightOnRectangleIcon, RocketLaunchIcon, HomeModernIcon, KeyIcon } from '@heroicons/vue/24/outline';
import { ref, reactive, computed, watch, shallowRef, onMounted } from 'vue';
import { useStore } from 'vuex';

const route = useRoute();
const store = useStore();

const isLoggedIn = computed(() => store.getters['auth/isLoggedIn'])
const userRoles = computed(() => store.getters['auth/user'])

const isAdmin = ref(false)
const isOwner = ref(false)

const userLink = computed(() => [
    { name: 'Mon profil', href: '/me/profile', isShow: isLoggedIn.value, icon: UserIcon },
    { name: 'Mes achats/ventes', href: '/me/list/orders/in-progress', isShow: isLoggedIn.value, icon: ShoppingCartIcon },
    { name: 'Administration', href: '/admin/users', isShow: isAdmin.value, icon: KeyIcon },
    { name: 'Ma concession', href: '/me/concession', isShow: isOwner.value, icon: HomeModernIcon },
    { name: 'Se déconnecter', href: '/logout', isShow: isLoggedIn.value, icon: ArrowLeftOnRectangleIcon },
    { name: 'Se connecter', href: '/login', isShow: !isLoggedIn.value, icon: ArrowRightOnRectangleIcon },
    { name: 'S\'inscrire', href: '/register', isShow: !isLoggedIn.value, icon: RocketLaunchIcon },
])
const showUserMenu = ref(false)

const navLink = reactive([
    { name: 'Les modèles', href: '/model', current: false },
    { name: 'Services', href: '/services', current: false },
    { name: 'Nos concessionaires', href: '/garage', current: false },
]);

const searchBar = reactive({
    show: false,
    value: ''
})

const handleSearch = () => {
    searchBar.show = !searchBar.show
}

watch(isLoggedIn, (val) => {
    isAdmin.value = userRoles.value ? userRoles.value.roles.includes('ROLE_ADMIN') : false
    isOwner.value = userRoles.value ? userRoles.value.roles.includes('ROLE_DEALER') : false
})

onMounted(() => {
    isAdmin.value = userRoles.value ? userRoles.value.roles.includes('ROLE_ADMIN') : false
    isOwner.value = userRoles.value ? userRoles.value.roles.includes('ROLE_DEALER') : false
})

</script>

<template>
    <nav class="w-full flex px-52 bg-white/10 sticky items-center z-20">
        <div class="flex h-24 items-center relative justify-between w-full">
            <div class="w-3/4 flex h-full">
                <div class="min-w-[6rem] text-center group h-full" v-for="link in navLink">
                    <router-link
                        class="h-full group-hover:bg-white/20 group-hover:cursor-pointer items-center text-center justify-center flex"
                        :to="link.href">
                        <div
                            :class="route.path.startsWith(link.href) ? 'text-blue-500 underline decoration-blue-600 decoration-4 underline-offset-[2.4rem]' : 'text-white group-hover:text-blue-500 text-center px-2 group-hover:underline decoration-blue-600 decoration-4 underline-offset-[2.4rem]'">
                            {{ link.name }}
                        </div>
                    </router-link>
                </div>
            </div>
            <div class="w-1/4 flex justify-end items-center space-x-3 relative">
                <div v-if="searchBar.show">
                    <input type="text" class="w-full h-full rounded-lg px-3 py-2 focus:outline-none shadow-md"
                        v-model="searchBar.value" placeholder="Rechercher un modèle" />
                </div>
                <MagnifyingGlassIcon class="h-6 w-6 cursor-pointer" @click="handleSearch" />
                <UserIcon class="h-6 w-6 cursor-pointer" @click="showUserMenu = !showUserMenu" />
                <div class="absolute bg-white w-52 max-h-[24rem] h-fit top-12 rounded-lg p-2 space-y-2 flex justify-start flex-col"
                    v-show="showUserMenu">
                    <template v-for="link in userLink">
                        <div class="flex group" v-if="link.isShow">
                            <router-link :to="link.href" @click="showUserMenu = false"
                                class="p-3 rounded-sm text-gray-700 min-w-full cursor-pointer group-hover:bg-slate-300 bg-slate-200 group-hover:text-white group-hover:shadow-inner group-hover:shadow-black">
                                <div class="flex space-x-2 items-center w-full text-left">
                                    <component :is="link.icon" class="h-6 w-6" />
                                    <span>{{ link.name }}</span>
                                </div>
                            </router-link>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <router-link class="flex items-center ml-5 rounded-full h-16 w-16" :to="'/home'">
            <img src="../assets/bmw_logo.png" alt=""
                class="rounded-full cursor-pointer hover:scale-110 hover:shadow-md hover:shadow-white duration-300">
        </router-link>
    </nav>
</template>