<script setup>
import Avatar from '../../components/Avatar.vue';
import { onMounted, reactive, ref } from 'vue';
import { PencilIcon } from '@heroicons/vue/24/outline';
import UserService from "../../services/user.service.js";
import JawgJSLoader from '@jawg/js-loader';

const loader = new JawgJSLoader({ accessToken: 'rFPvpCTSLFoCgow6L3gmxotGfuCGOdg4IJUasbdb7JsGs6pgek324aK6hnAZx2kJ' });



const formData = reactive({});
const editMode = ref(true);

const handleSendUpdate = async (form) => {
    const response = await UserService.Patch('me', form);
};

onMounted(async () => {
    const me = await UserService.get('me');
    formData.firstName = me.firstName;
    formData.lastName = me.lastName;
    formData.email = me.email;
    formData.coordinates = me.coordinates;

    loader.loadJawgPlaces().then((JawgPlaces) => {
      let jawgPlaces = new JawgPlaces.Input({ input: '#address' });
    });
});
</script>
<template>
    <div class="mx-auto flex justify-center items-center h-full">
        <div class="h-fit w-[70vw] bg-white/20 rounded-lg mt-20">
            <div
                class="bg-[url('/public/bg_header2.jpg')] w-full h-[30vh] bg-center bg-cover relative rounded-t-lg shadow-xl shadow-slate-500">
                <div class="absolute w-full flex justify-center -bottom-14">
                    <Avatar name="Loan CLERIS" :color="{ background: 'bg-gray-900/80', text: 'text-white' }" />
                    <div class="h-10 w-10 bottom-0 right-5 absolute rounded-full bg-white/10 p-3 items-center flex hover:bg-white/20 cursor-pointer z-10"
                        @click="editMode = !editMode">
                        <PencilIcon class="w-8 h-8" />
                    </div>
                </div>
            </div>
            <div class="relative h-[120vh] w-full flex justify-evenly">
                <div class="absolute top-20 w-1/2 h-1/2">
                    <FormKit type="form" @submit="handleSendUpdate" v-model="formData" submitLabel="Mettre à jour" :disabled="editMode">
                        <FormKit type="text" name="firstName" label="Prénom" />
                        <FormKit type="text" name="lastName" label="Nom" />
                        <FormKit type="text" name="email" label="Email" />
                        <FormKit type="text" name="phone" label="Téléphone" />
                        <input type="text" name="address" id="address" />
                    </FormKit>
                </div>
                <div class="absolute bottom-5 px-3 w-full grid grid-flow-row grid-cols-2 gap-2 h-1/2 overflow-scroll">
                    <div
                        class="object-cover flex items-center relative flex-col text-center rounded-lg bg-white/10 max-h-64">
                        <img src="../../assets/bmw_serie_1.png" alt=""
                            class="w-96 h-52 hover:scale-150 ease-in-out duration-500 absolute" />
                        <span class="absolute bottom-4">BMW Serie 1 | 2022</span>
                    </div>
                </div>
            </div>
            <div>

            </div>
        </div>
    </div>
</template>