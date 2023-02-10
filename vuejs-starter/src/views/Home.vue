<script setup>
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import VerticalArtcile from "../components/VerticalArtcile.vue";
import Footer from "../components/Footer.vue";
console.log("process.env.VUE_APP_API_URL", import.meta.env.VITE_API_URL);
const store = useStore();
const router = useRouter();
</script>

<template>
    <div class="w-full h-screen">
        <header class="h-[70vh] -mt-24 bg-[url('/bg_header.jpg')] bg-cover bg-center">
            <div class="relative">
                <h1 class="uppercase top-28 left-32 absolute text-3xl font-extrabold tracking-wider">
                    Achat de véhicules neuf ou d'occasion
                </h1>
            </div>
        </header>

        <body class="my-5 space-y-10">
            <VerticalArtcile reversed>
                <template #title>
                    <h1 class="text-2xl font-bold">LE PLAISIR DE LA CONDUITE. ÉLECTRIQUE.</h1>
                </template>
                <template #content>
                    <div class="flex justify-between h-full flex-col space-y-5">
                        <ul class="text-gray-500 space-y-3">
                            <li>- Une toute nouvelle expérience de conduite chargée d’émotion</li>
                            <li>- Accélération fluide depuis l’arrêt</li>
                            <li>
                                - Dynamique électrisante et conduite sereine – une sensation de glisse dans un silence
                                presque parfait
                            </li>
                        </ul>
                        <button class="w-[15rem]" @click="router.push('/e-brid')">Je découvre</button>
                    </div>
                </template>
                <template #image>
                    <img class="w-full h-full object-cover"
                        src="https://www.bmw.be/content/dam/bmw/common/topics/fascination-bmw/electromobility2020-new/bev-new/bmw-emobility-bev-wide-teaser-charging.jpg/jcr:content/renditions/cq5dam.resized.img.500.low.time1631810888822.jpg"
                        alt="" />
                </template>
            </VerticalArtcile>
            <VerticalArtcile>
                <template #title>
                    <h1 class="text-2xl font-bold">LE PLAISIR DE CONDUIRE SE NOMME BMW xDRIVE</h1>
                </template>
                <template #content>
                    <p class="text-gray-500">
                        Appliquer la puissance là où elle exerce un effet maximum – c’est cette idée simple que le
                        système de transmission intégrale intelligent BMW xDrive s’emploie à mettre en pratique avec
                        maestria. Il répartit la force motrice entre les essieux en une fraction de seconde de manière à
                        produire une traction maximale. Sur la neige et le verglas, dans les virages serrés, les
                        démarrages en côte ou sur revêtement glissant, la puissance est transmise à la route dans les
                        meilleures proportions.
                    </p>
                </template>
                <template #image>
                    <img class="w-full h-full object-cover"
                        src="https://www.bmw.be/content/dam/bmw/common/topics/fascination-bmw/xdrive/xdrive_introduction/xdriveintroduction-stagepresentation.jpg/jcr:content/renditions/cq5dam.resized.img.1680.large.time1448188103356.jpg"
                        alt="" />
                </template>
            </VerticalArtcile>
        </body>
        <Footer />
    </div>
</template>