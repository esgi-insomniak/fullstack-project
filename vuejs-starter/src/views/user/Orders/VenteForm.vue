<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router';
import SkeletonModelCars from '../../../components/Skeleton/SkeletonModelCars.vue';
import CarService from '../../../services/car.service';
import GarageService from '../../../services/garage.service';
import RecoveryService from '../../../services/recovery.service';
import UserService from '../../../services/user.service';

const formData = ref({
    carIdentity: '',
    year: '',
    proposedPrice: '',
    km: '',
    garage: '',
    power: '',
    gearbox: '',
    fuel: '',
    carDescription: '',
    recoverer: ''
});
const modelSelected = ref(null);
const model = ref([])
const garage = ref([])
const previewModel = ref('')
const me = ref(null)
const router = useRouter();

const handleSubmit = (form) => {
    const toBeSubmitted = {
        carIdentity: `/car_identities/${form.carIdentity}`,
        year: form.year,
        proposedPrice: parseFloat(form.proposedPrice),
        kilometers: form.kilometers,
        garage: `/garages/${form.garage}`,
        power: form.power,
        gearbox: form.gearbox,
        fuel: form.fuel,
        carDescription: form.carDescription,
        recoverer: `/users/${me.value.id}`,
        progression: 'in-progress'
    }
    RecoveryService.post(toBeSubmitted).then(() => {
        router.push({ name: 'UserSalesEdit', params: { slug: 'in-progress' } })
    });
}
const handlePictureChange = () => {
    const img = model.value.find(item => item.id === modelSelected.value).mainPicture.src
    previewModel.value = img
}
onMounted(async () => {
    model.value = await CarService.getCarIdentityCollection({
        itemsPerPage: 100
    })
    garage.value = await GarageService.getCollection({
        itemsPerPage: 100
    })
    me.value = await UserService.get('me')
});
</script>
<template>
    <FormKit type="form" form-class="grid grid-flow-row grid-cols-2 gap-3" v-model="formData" @submit="handleSubmit">
        <FormKit type="select" name="carIdentity" label="Model" placeholder="Model" :options="model.map((item) => {
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
        <FormKit type="number" name="kilometers" label="Km" placeholder="Km" required />
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
</template>


<!-- -->