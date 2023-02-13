<script setup>
import Avatar from '../../components/Avatar.vue';
import { onMounted, reactive, ref } from 'vue';
import { PencilIcon } from '@heroicons/vue/24/outline';
import UserService from "../../services/user.service.js";
import Map from "../../components/Map.vue";
const defaultData = {
  firstName: '',
  lastName: '',
  email: '',
  coordinates: [],
  address: '',
};
const formData = reactive({
  data: defaultData
});
const editMode = ref(true);
const me = ref(null);

const handleSendUpdate = async (form) => {
  const response = await UserService.patch('me', form);
  if (response) {
    editMode.value = false;
  }
};

const handleMapClick = (feature) => {
  formData.data.coordinates = feature.geometry.coordinates;
  formData.data.address = feature.properties.label;
};

const handleMapError = (e) => {
  console.error(e);
};


onMounted(async () => {
  me.value = await UserService.get("me");
  me.value.coordinates = me.value.coordinates.reverse();
  formData.data = {
    firstName: me.value.firstName,
    lastName: me.value.lastName,
    email: me.value.email,
    coordinates: me.value.coordinates,
    address: me.value.address,
  };
});
</script>
<template>
  <div class="mx-auto flex justify-center items-center h-[88vh]">
    <div class="h-fit w-[70vw] bg-white/20 rounded-lg mt-20" v-if="me">
      <div
        class="bg-[url('/public/bg_header2.jpg')] w-full h-[30vh] bg-center bg-cover relative rounded-t-lg shadow-xl shadow-slate-500">
        <div class="absolute w-full flex justify-center -bottom-14">
          <Avatar :name="me.firstName + ' ' + me.lastName"
            :color="{ background: 'bg-gray-900/80', text: 'text-white' }" />
          <div
            class="h-10 w-10 bottom-0 right-5 absolute rounded-full bg-white/10 p-3 items-center flex hover:bg-white/20 cursor-pointer z-10"
            @click="editMode = !editMode">
            <PencilIcon class="w-8 h-8" />
          </div>
        </div>
      </div>
      <div class="w-full flex flex-col items-center p-5 mt-[75px]">
        <div class="flex flex-row items-center">
          <FormKit type="form" @submit="handleSendUpdate" v-model="formData.data" submitLabel="Mettre à jour"
            :disabled="editMode">
            <FormKit type="text" name="firstName" label="Prénom" placeholder="Karl" validation="required|alpha" />
            <FormKit type="text" name="lastName" label="Nom" placeholder="Marques" validation="required|alpha" />
            <FormKit type="text" name="email" label="Email" placeholder="exemple@email.here"
              validation="required|email" />
            <FormKit type="text" name="tel" label="Numéro de téléphone" placeholder="xx-xx-xx-xx-xx"
              validation="['matches', /^\d{2}-\d{2}-\d{2}-\d{2}-\d{2}$/]]" />
          </FormKit>
          <div class="m-3">
            <Map :default-point="{
              name: me.address,
              coordinates: me.coordinates,
            }" :zoom="11" :width="'350px'" :height="'350px'" @on-map-click="handleMapClick"
              @on-map-error="handleMapError" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>