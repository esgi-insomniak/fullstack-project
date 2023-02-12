<script setup>
import { reactive } from 'vue'
const formData = reactive({
    name: '',
    model: '',
    year: '',
    chasis: '',
    price: '',
    km: '',
    power: '',
    gearbox: '',
    fuel: '',
    location: '',
    consumption: '',
    doors: '',
    image: '',
})
const model = [
    { value: 'BMW', label: 'BMW' },
    { value: 'Mercedes', label: 'Mercedes' },
    { value: 'Audi', label: 'Audi' },
    { value: 'Porsche', label: 'Porsche' },
    { value: 'Ferrari', label: 'Ferrari' },
    { value: 'Lamborghini', label: 'Lamborghini' },
    { value: 'Bugatti', label: 'Bugatti' },
    { value: 'McLaren', label: 'McLaren' },
    { value: 'Koenigsegg', label: 'Koenigsegg' },
    { value: 'Pagani', label: 'Pagani' },
    { value: 'Rolls-Royce', label: 'Rolls-Royce' },
    { value: 'Bentley', label: 'Bentley' },
    { value: 'Maserati', label: 'Maserati' },
    { value: 'Alfa Romeo', label: 'Alfa Romeo' },
    { value: 'Aston Martin', label: 'Aston Martin' },
    { value: 'Jaguar', label: 'Jaguar' },
    { value: 'Land Rover', label: 'Land Rover' },
    { value: 'Lotus', label: 'Lotus' },
    { value: 'Morgan', label: 'Morgan' },
    { value: 'Nissan', label: 'Nissan' },
    { value: 'Infiniti', label: 'Infiniti' },
    { value: 'Toyota', label: 'Toyota' },
    { value: 'Lexus', label: 'Lexus' },
    { value: 'Honda', label: 'Honda' },
    { value: 'Acura', label: 'Acura' },
    { value: 'Mazda', label: 'Mazda' },
    { value: 'Subaru', label: 'Subaru' },
    { value: 'Mitsubishi', label: 'Mitsubishi' },
    { value: 'Suzuki', label: 'Suzuki' },
    { value: 'Hyundai', label: 'Hyundai' },
    { value: 'Kia', label: 'Kia' },
]
const handleSubmit = (form) => {
    console.log(form)
}
</script>
<template>
    <FormKit type="form" form-class="grid grid-flow-row grid-cols-2 gap-3" v-model="formData" @submit="handleSubmit">
        <FormKit type="text" name="name" label="Name" placeholder="Name" />
        <FormKit type="select" name="model" label="Model" placeholder="Model" :options="model" />
        <FormKit type="date" name="year" label="Year" placeholder="Year" />
        <FormKit type="text" name="chasis" label="Chasis" placeholder="Chasis" />
        <FormKit type="text" name="price" label="Price" placeholder="Price" />
        <FormKit type="number" name="km" label="Km" placeholder="Km" />
        <FormKit type="text" name="power" label="Power" placeholder="Power" />
        <FormKit type="text" name="gearbox" label="Gearbox" placeholder="Gearbox" />
        <FormKit type="text" name="fuel" label="Fuel" placeholder="Fuel" />
        <FormKit type="text" name="location" label="Location" placeholder="Location" />
        <FormKit type="text" name="consumption" label="Consumption" placeholder="Consumption" />
        <FormKit type="text" name="doors" label="Doors" placeholder="Doors" />
        <FormKit type="file" name="image" label="Image" placeholder="Image" accept=".jpg,.png,.svg" multiple />
    </FormKit>
</template>


<!-- -->