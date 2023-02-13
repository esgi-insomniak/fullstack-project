<script setup>
import { ref, onMounted } from 'vue'
import SkeletonModelCars from '../../../components/Skeleton/SkeletonModelCars.vue';
import CarService from '../../../services/car.service';
import GarageService from '../../../services/garage.service';
import RecoveryService from '../../../services/recovery.service';
import UserService from '../../../services/user.service';

const formData = ref({
    car: '',
    year: '',
    proposedPrice: '',
    km: '',
    power: '',
    gearbox: '',
    fuel: '',
    carDescription: '',
    recover: ''
});
const modelSelected = ref(null);
const model = ref([])
const garage = ref([])
const previewModel = ref('')
const me = ref(null)

const handleSubmit = (form) => {
    const toBeSubmitted = {
        car: form.car,
        year: form.year,
        proposedPrice: form.proposedPrice,
        km: form.km,
        power: form.power,
        gearbox: form.gearbox,
        fuel: form.fuel,
        carDescription: form.carDescription,
        recover: me.value.id,
    }
    // RecoveryService.post(toBeSubmitted)
    console.log(toBeSubmitted)
}
const handlePictureChange = () => {
    const img = model.value.find(item => item.id === modelSelected.value).mainPicture.src
    previewModel.value = img
}
onMounted(async () => {
    model.value = await CarService.getCarIdentityCollection()
    garage.value = await GarageService.getCollection()
    me.value = await UserService.get('me')
});
</script>
<template>
    <FormKit type="form" form-class="grid grid-flow-row grid-cols-2 gap-3" v-model="formData" @submit="handleSubmit">
        <FormKit type="select" name="car" label="Model" placeholder="Model" :options="model.map((item) => {
            return {
                value: item.id,
                label: item.name
            }
        })" v-model="modelSelected" @change="handlePictureChange" required />
        <FormKit type="select" name="garage" label="Garage" placeholder="Garage" :options="garage.map((item) => {
            return {
                value: item.id,
                label: item.name
            }
        })" required />
        <FormKit type="date" name="year" label="Date mise en circulation" placeholder="Year" required />
        <FormKit type="text" name="proposedPrice" label="Prix estimé" placeholder="Prix estimé" required />
        <FormKit type="number" name="km" label="Km" placeholder="Km" required />
        <FormKit type="text" name="power" label="CV" placeholder="Puissance" required />
        <FormKit type="select" name="gearbox" label="Boite à vitesse" placeholder="Boite à vitesse" :options="[
            {
                value: 'manual',
                label: 'Manual'
            },
            {
                value: 'automatic',
                label: 'Automatic'
            }
        ]" required />
        <FormKit type="select" name="fuel" label="Carburant" placeholder="Carburant" :options="[
            {
                value: 'diesel',
                label: 'Diesel'
            },
            {
                value: 'essence',
                label: 'Essence'
            },
            {
                value: 'hybrid',
                label: 'Hybrid'
            },
            {
                value: 'electric',
                label: 'Electric'
            }
        ]" required />
        <FormKit type="textarea" name="carDescription" label="Description" placeholder="Description" />
    </FormKit>
    <div v-if="previewModel !== ''" class="w-96 h-96">
        <img :src="previewModel" alt="" class="object-cover">
    </div>
    <div v-else>
        <SkeletonModelCars />
    </div>
</template>


<!-- -->