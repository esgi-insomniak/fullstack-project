<script setup>
import { reactive, onMounted, ref } from 'vue';
import { onBeforeRouteUpdate, useRoute } from 'vue-router';
import RecoveryService from "../../../services/recovery.service.js";
import StatusService from "../../../services/status.service.js";
import Modal from "../../../components/Modal.vue";
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline';
import moment from 'moment/dist/moment';
import fr from 'moment/dist/locale/fr';
moment.locale('fr', fr);

const route = useRoute();
const recoveries = reactive([]);
const slug = ref(route.params.slug);

onMounted(async () => {
    recoveries.values = await RecoveryService.getUserRecoveries('me');
});

onBeforeRouteUpdate(async (to) => {
    slug.value = to.params.slug;
});

const filterRecoveries = () => {
    if (slug.value && slug.value !== 'all') {
        return Object.values(recoveries.values).filter((recover) => recover.progression === slug.value);
    }
    return recoveries.values;
};

const cancelRecover = async (recover) => {
    if (!recover.status.canCancel || recover.progression !== 'in-progress') return
    const updatedRecover = await RecoveryService.patch(recover.id, { progression: 'canceled' });
    recoveries.values = recoveries.values.map((r) => {
        if (r.id === recover.id) {
            r.progression = updatedRecover.progression;
            r.status.canCancel = updatedRecover.status.canCancel;
        }
        return r;
    });
    toggleModal();
};

const loadCancelModal = (recover) => {
    if (!recover.status.canCancel || recover.progression !== 'in-progress') return
    modalProps.id = 'cancel-order-modal';
    modalProps.title = 'Annuler la commande ?';
    modalProps.content = 'Si vous annulez la commande, vous ne pourrez plus revenir en arrière. Voulez-vous vraiment annuler la commande ?'
    modalProps.icon = {
        type: ExclamationTriangleIcon,
        bgColor: 'bg-red-100',
        textColor: 'text-red-600'
    };
    modalProps.buttons = [
        {
            text: 'Annuler la commande',
            class: 'inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm',
            action: async () => await cancelRecover(recover)
        },
        {
            text: 'Fermer',
            class: 'mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm',
            action: toggleModal
        }
    ]
    toggleModal();
};

const loadDetailsModal = (recover) => {
    modalProps.id = 'recovery-details-modal';
    modalProps.title = 'Détails de la commande';
    modalProps.content = `Vente number: ${recover.id}<br>Année: ${recover.year}<br>Status: ${recover.status.name}<br>Montant: ${recover.proposedPrice} €`;
    modalProps.icon = null;
    modalProps.buttons = [
        {
            text: 'Fermer',
            class: 'mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm',
            action: toggleModal
        }
    ]
    toggleModal();
}

const toggleModal = () => {
    modalProps.open = !modalProps.open
};

const modalProps = reactive({
    open: false,
    toggle: toggleModal,
});

</script>

<template>
    <Modal v-bind="{ ...modalProps }"/>
    <div class="bg-blue-500/60 " />
    <div class="bg-yellow-500/60" />
    <div class="bg-green-500/60" />
    <div v-for="recover in filterRecoveries()" :key="recover.id" class="py-3">
        <div class="w-full h-52 rounded-lg bg-white/20 flex shadow-inner shadow-slate-200">
            <div class="relative w-1/5 h-full">
                <div class="absolute -left-32 -top-5 h-52 w-96 hover:scale-110 duration-300 ease-in-out bg-cover">
                    <img :src="recover.carIdentity.mainPicture.src" class="h-full w-full object-cover bg-cover" />
                </div>
            </div>
            <div class="relative w-full py-5 px-5 flex flex-col space-y-5 ml-10 item-start">
                <div class="flex justify-between w-full h-full">
                    <div class="flex flex-col w-4/6">
                        <span>Modèle : {{ recover.carIdentity.name }}</span>
                        <span>Prix de vente : {{ recover.proposedPrice }} €</span>
                        <span>Status de la vente : {{ recover.status.name }}</span>
                    </div>
                    <div class="flex flex-col w-2/6 h-full justify-between items-center">
                        <div v-on:click="loadDetailsModal(recover)"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded h-auto text-center hover:cursor-pointer w-[80%] max-w-[200px]">
                            Plus de détails</div>
                        <div class="text-white font-bold py-2 px-4 border rounded h-auto text-center w-[80%] max-w-[200px]"
                            v-on:click="loadCancelModal(recover)"
                            :class="[(recover.status.canCancel && recover.progression === 'in-progress') ? 'border-red-500 bg-red-500 hover:bg-red-700 hover:cursor-pointer' : 'border-gray-500 bg-gray-500']">
                            Annuler</div>
                    </div>
                </div>
                <div class="flex w-full justify-between text-right">
                    <span class="min-w-[3rem]" />
                    <span class="min-w-[3rem]">Voiture ajouté</span>
                    <span class="min-w-[3rem]">Vendu</span>
                    <span class="min-w-[3rem]">Livré</span>
                </div>
                <div>
                    <div class="w-full bg-white/20 shadow-md rounded-full h-2">
                        <div class="shadow-inner shadow-blue-300 rounded-full h-full" :class="recover.status.bgColor"
                            :style="{ width: recover.status.width }">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>