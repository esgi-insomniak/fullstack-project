<script setup>
import { ref } from 'vue'
const questions = [
    {
        label: 'Pour quelle raison souhaitez vous prendre RDV ?', type: 'radio', options: [
            { label: 'Révision', value: 'revision', id: 1 },
            { label: 'Réparation', value: 'reparation', id: 2 },
            { label: 'Vidange', value: 'vidange', id: 3 },
            { label: 'Autre', value: 'autre', id: 4 },
        ], step: 1, name: 'reason'
    },
    {
        label: 'Quel est le modèle de votre véhicule ?', type: 'select', step: 2, options: [
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
        ], name: 'model'
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
        label: 'Quel est le type de carrosserie de votre véhicule ?', type: 'select', options: [
            { label: 'Berline', value: 'berline' },
            { label: 'Break', value: 'break' },
            { label: 'Coupé', value: 'coupe' },
            { label: 'Cabriolet', value: 'cabriolet' },
            { label: '4x4', value: '4x4' },
            { label: 'Monospace', value: 'monospace' },
            { label: 'Utilitaire', value: 'utilitaire' },
        ], step: 6, name: 'body'
    },
    { label: 'Selectionnez un créneau qui vous convient:', type: 'datetime-local', step: 7, name: 'appointement' }
]
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

console.log(answers.value)

</script>

<template>
    <div class="h-[88vh] w-full py-10">
        <div class="flex flex-col px-64 h-full overflow-scroll" v-if="currentQuestion !== questions.lenght + 1">
            <FormKit type="form" @submit="nextQuestion"
                :submit-label="currentQuestion === questions.length ? 'Demande de RDV' : 'Question suivante'">
                <template v-for="question in questions">
                    <FormKit :type="question.type" :name="question.name" :label="question.label"
                        :options="question.options" v-if="question.step === currentQuestion" />
                </template>
            </FormKit>
        </div>
        <div v-show="currentQuestion === questions.length + 1">
            Questionnaire terminer

        </div>
    </div>

</template>