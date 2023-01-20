<script setup>
import { ref } from 'vue'
import RadioGroup from '../components/RadioGroup.vue'
const questions = [
    {
        name: 'Pour quelle raison souhaitez vous prendre RDV ?', type: 'radio', options: [
            { label: 'Révision', value: 'revision', id: 1 },
            { label: 'Réparation', value: 'reparation', id: 2 },
            { label: 'Vidange', value: 'vidange', id: 3 },
            { label: 'Autre', value: 'autre', id: 4 },
        ], step: 1
    },
    {
        name: 'Quel est le modèle de votre véhicule ?', type: 'select', step: 2, options: [
            { label: 'Audi', value: 'audi' },
            { label: 'BMW', value: 'bmw' },
            { label: 'Citroen', value: 'citroen' },
            { label: 'Fiat', value: 'fiat' },
            { label: 'Ford', value: 'ford' },
            { label: 'Honda', value: 'honda' },
            { label: 'Hyundai', value: 'hyundai' },
            { label: 'Kia', value: 'kia' },
            { label: 'Lexus', value: 'lexus' },
            { label: 'Mazda', value: 'mazda' },
            { label: 'Mercedes', value: 'mercedes' },
            { label: 'Mini', value: 'mini' },
            { label: 'Nissan', value: 'nissan' },
            { label: 'Opel', value: 'opel' },
            { label: 'Peugeot', value: 'peugeot' },
            { label: 'Renault', value: 'renault' },
            { label: 'Seat', value: 'seat' },
            { label: 'Skoda', value: 'skoda' },
            { label: 'Suzuki', value: 'suzuki' },
            { label: 'Toyota', value: 'toyota' },
            { label: 'Volkswagen', value: 'volkswagen' },
            { label: 'Volvo', value: 'volvo' },
        ]
    },
    { name: 'Quel est le kilométrage de votre véhicule ?', type: 'number', step: 2 },
    {
        name: 'Quel est le type de carburant de votre véhicule ?', type: 'radio', options: [
            { label: 'Essence', value: 'essence', id: 1 },
            { label: 'Diesel', value: 'diesel', id: 2 },
            { label: 'Hybride', value: 'hybride', id: 5 },
            { label: 'Electrique', value: 'electrique', id: 6 },
        ], step: 2
    },
    {
        name: 'Quel est le type de boite de vitesse de votre véhicule ?', type: 'radio', options: [
            { label: 'Manuelle', value: 'manuelle', id: 1 },
            { label: 'Automatique', value: 'automatique', id: 2 },
        ], step: 3
    },
    {
        name: 'Quel est le type de carrosserie de votre véhicule ?', type: 'select', options: [
            { label: 'Berline', value: 'berline' },
            { label: 'Break', value: 'break' },
            { label: 'Coupé', value: 'coupe' },
            { label: 'Cabriolet', value: 'cabriolet' },
            { label: '4x4', value: '4x4' },
            { label: 'Monospace', value: 'monospace' },
            { label: 'Utilitaire', value: 'utilitaire' },
        ], step: 4
    },
    { name: 'Selectionnez un créneau qui vous convient:', type: 'datetime', step: 5 }
]
const answers = ref([])
const currentQuestion = ref(0)
const nextQuestion = (e) => {
    e.preventDefault()
    currentQuestion++
}
const previousQuestion = (e) => {
    e.preventDefault()
    currentQuestion--
}

</script>


<template>
    <form class="p-6 rounded-lg">
        <div v-for="(question, index) in questions" :key="index" :v-if="currentQuestion === index">
            <label class="block text-white font-medium">{{ question.name }}</label>
            <div v-if="question.type === 'radio'">
                <RadioGroup :options="question.options" />
            </div>
            <div v-if="question.type === 'select'">
                <select
                    class="block p-3 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-none">
                    <option v-for="option in question.options" :key="option.value" :value="option.value">
                        {{ option.label }}
                    </option>
                </select>
            </div>
            <div v-if="question.type === 'number'">
                <input type="number"
                    class="block p-3 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-none">
            </div>
            <div v-if="question.type === 'datetime'">
                <input type="datetime-local"
                    class="block p-3 w-full mt-1 border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-none">
            </div>

        </div>
        <div class="text-center mt-6">
            <button v-if="currentQuestion > 0" @click="previousQuestion"
                class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">Previous</button>
            <button v-if="currentQuestion < questions.length - 1" @click="nextQuestion"
                class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">Next</button>
            <pre>{{ currentQuestion }}</pre>
            <button v-if="currentQuestion === questions.length - 1" type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">Submit</button>
        </div>
    </form>
</template>
