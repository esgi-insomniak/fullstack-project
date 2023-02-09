<script setup>
import { ref, onMounted } from 'vue'
import carService from '../services/car.service';
import GarageService from '../services/garage.service';
const questions = ref([
    {
        label: 'Pour quelle raison souhaitez vous prendre RDV ?', type: 'radio', options: [
            { label: 'Révision', value: 'revision', id: 1 },
            { label: 'Réparation', value: 'reparation', id: 2 },
            { label: 'Vidange', value: 'vidange', id: 3 },
            { label: 'Autre', value: 'autre', id: 4 },
        ], step: 1, name: 'reason'
    },
    {
        label: 'Quel est le modèle de votre véhicule ?', type: 'select', step: 2, options: [], name: 'model'
    },
    { label: 'Quel est le kilométrage de votre véhicule ?', type: 'number', step: 3, name: 'kilometrage' },
    {
        label: 'Quel est le type de carburant de votre véhicule ?', type: 'radio', options: [
            { label: 'Essence', value: 'essence', id: 1 },
            { label: 'Diesel', value: 'diesel', id: 2 },
            { label: 'Hybride', value: 'hybride', id: 5 },
            { label: 'Electrique', value: 'electrique', id: 6 },
        ], step: 4, name: 'fuel'
    },
    {
        label: 'Quel est le type de boite de vitesse de votre véhicule ?', type: 'radio', options: [
            { label: 'Manuelle', value: 'manuelle', id: 1 },
            { label: 'Automatique', value: 'automatique', id: 2 },
        ], step: 5, name: 'gearbox'
    },
    {
        label: 'Choisissez votre concession', type: 'select ', options: [], step: 6, name: 'concession'
    },
    { label: 'Selectionnez un créneau qui vous convient:', type: 'datetime-local', step: 7, name: 'appointement' }
])
const answers = ref([])
const currentQuestion = ref(1)
const nextQuestion = (userChoice) => {
    answers.value.push(userChoice)
    currentQuestion.value++
}
const previousQuestion = (e) => {
    e.preventDefault()
    currentQuestion.value--
}
onMounted(async () => {
    const models = await carService.getCarIdentityCollection()
    questions.value[1].options = models.map(model => {
        return { label: model.name, value: model.id }
    })
    const garages = await GarageService.getCollection()
    questions.value[5].options = garages.map(garage => {
        return { label: garage.name, value: garage.id }
    })
})
console.log(questions)

</script>

<template>
    <div class="h-[88vh] w-full flex justify-center items-center">
        <div class="flex flex-col h-full overflow-scroll justify-center items-center w-[70vw] relative"
            v-if="currentQuestion < questions.length + 1">
            <div class="absolute top-16 flex items-center justify-start w-full space-x-5">
                <button @click="previousQuestion" v-if="currentQuestion !== 1" class="left-56">
                    Question précédente
                </button>
                <span class="font-bold text-xl">
                    Etape {{ currentQuestion }}/{{ questions.length }}
                </span>
            </div>
            <FormKit type="form" @submit="nextQuestion" form-class="w-full"
                :submit-label="currentQuestion === questions.length ? 'Demande de RDV' : 'Question suivante'">
                <template v-for="question in questions">
                    <FormKit :type="question.type" :name="question.name" :label="question.label"
                        :options="question.options" v-if="question.step === currentQuestion" />
                </template>
            </FormKit>
        </div>
        <div v-else>
            Questionnaire terminer
        </div>
    </div>

</template>