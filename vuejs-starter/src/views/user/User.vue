<script setup>
import Avatar from '../../components/Avatar.vue';
import { onMounted, reactive, ref } from 'vue';
import { PencilIcon } from '@heroicons/vue/24/outline';
import UserService from "../../services/user.service.js";
import JawgJSLoader from '@jawg/js-loader';

const loader = new JawgJSLoader({ accessToken: 'rFPvpCTSLFoCgow6L3gmxotGfuCGOdg4IJUasbdb7JsGs6pgek324aK6hnAZx2kJ' });

const formData = reactive({});
const editMode = ref(true);
const cars = ref([]);
const me = ref({
  firstName: '',
  lastName: '',
  email: '',
  coordinates: [],
});

const handleSendUpdate = async (form) => {
    const response = await UserService.patch('me', form);
};

onMounted(async () => {
    me.value = await UserService.get('me');
    formData.firstName = me.value.firstName;
    formData.lastName = me.value.lastName;
    formData.email = me.value.email;
    formData.coordinates = me.value.coordinates;
    //formData.address = me.value.address;
});
</script>
<template>
    <div class="mx-auto flex justify-center items-center h-full">
        <div class="h-fit w-[70vw] bg-white/20 rounded-lg mt-20">
            <div
                class="bg-[url('/public/bg_header2.jpg')] w-full h-[30vh] bg-center bg-cover relative rounded-t-lg shadow-xl shadow-slate-500">
                <div class="absolute w-full flex justify-center -bottom-14">
                    <Avatar :name="me.firstName + ' ' + me.lastName" :color="{ background: 'bg-gray-900/80', text: 'text-white' }" />
                    <div class="h-10 w-10 bottom-0 right-5 absolute rounded-full bg-white/10 p-3 items-center flex hover:bg-white/20 cursor-pointer z-10"
                        @click="editMode = !editMode">
                        <PencilIcon class="w-8 h-8" />
                    </div>
                </div>
            </div>
            <div class="w-full flex flex-col items-center py-5">
                <div class="w-1/3">
                    <FormKit type="form" @submit="handleSendUpdate" v-model="formData" submitLabel="Mettre à jour" :disabled="editMode">
                        <FormKit type="text" name="firstName" label="Prénom" />
                        <FormKit type="text" name="lastName" label="Nom" />
                        <FormKit type="text" name="email" label="Email" />
                        <FormKit type="text" name="phone" label="Téléphone" />
                        <FormKit type="text" name="address" id="address" label="Adresse" />
                    </FormKit>
                </div>
                <div class="w-3/4">
                    <h2 class="text-2xl font-bold text-white/80 mt-10 mb-5">
                      Mes Favoris
                    </h2>
                </div>
            </div>
        </div>
    </div>
</template>