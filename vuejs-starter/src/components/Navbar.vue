<script setup>
import { useRouter } from 'vue-router';
import { UserIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline';

const router = useRouter()
const navLink = [
    { name: 'Les modèles', href: '/model', current: router.hasRoute('model') },
    { name: 'Achat', href: '/achat', current: router.hasRoute('achat') },
    { name: 'Electrique & Hybride Rechargeable', href: '/e-brid', current: router.hasRoute('e-brid') },
    { name: 'Services', href: '/services', current: router.hasRoute('services') },
    { name: 'Nos concessionaires', href: '/garage', current: router.hasRoute('garage') },
]
</script>

<template>
    <nav class="w-full flex px-52 bg-white/10">
        <div class="flex h-24 items-center relative justify-between w-full shadow px-2">
            <div class="w-3/4 flex h-full">
                <div class="min-w-[6rem] text-center group h-full" v-for="link in navLink">
                    <div
                        class="h-full group-hover:bg-white/20 group-hover:cursor-pointer items-center text-center justify-center flex">
                        <a :href="link.href" class="text-white group-hover:text-blue-400 text-center">
                            {{ link.name }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-1/4 flex justify-end items-center space-x-3">
                <MagnifyingGlassIcon class="h-10 w-10 cursor-pointer" />
                <UserIcon class="h-10 w-10 cursor-pointer" />
            </div>
        </div>
        <div class="flex items-center ml-5">
            <img src="../assets/bmw_logo.png" alt="" class="h-16 w-16">
        </div>
    </nav>
</template>