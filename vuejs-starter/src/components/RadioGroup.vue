<script setup>
import { ref, defineProps, defineEmits } from 'vue'
const props = defineProps({
    options: {
        type: Array,
        required: true,
    },
    flexDirection: {
        type: String,
        default: 'flex-col',
    },
    positionFlex: {
        type: String,
        default: 'justify-center',
    },
})
const selected = ref(0)
const handleChange = (option) => {
    if (selected.value === option.id) {
        selected.value = 0
        emit('onSelected', undefined)
        return
    }
    else {
        selected.value = option.id
        emit('onSelected', option.id)
    }
}
const emit = defineEmits(['onSelected'])
</script>  

<template>
    <div :class="[
        'w-full',
        { 'px-4 py-2': flexDirection === 'flex-col' }
    ]">
        <div class="mx-auto">
            <div :class="[
                'flex flex-wrap {{ positionFlex }}',
                {
                    'flex-row space-x-2': flexDirection === 'flex-row',
                    'flex-col space-y-2': flexDirection === 'flex-col',
                }
            ]">
                <template v-for="(option, index) in options" :key="index">
                    <div :class="[
                        'relative flex cursor-pointer rounded-lg px-5 py-4 shadow-md focus:outline-none',
                        {
                            'ring-2 ring-white ring-opacity-60 ring-offset-2 ring-offset-sky-300': active === index,
                            'bg-sky-600 shadow-inner shadow-black bg-opacity-75 text-white': selected === option.id,
                            'bg-white': selected !== option
                        }
                    ]" @click="handleChange(option)">
                        <div class="flex w-full items-center justify-between">
                            <div class="flex items-center">
                                <div class="text-sm">
                                    <p class="font-medium"
                                        :class="[selected === option.id ? 'text-white' : 'text-gray-900']">
                                        {{
                                            option.label || option.name
                                        }}
                                    </p>
                                </div>
                            </div>
                            <template v-if="selected === option.id">
                                <div class="shrink-0 text-green-500">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                                        <circle cx={12} cy={12} r={12} fill="#fff" opacity="0.2" />
                                        <path d="M7 13l3 3 7-7" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
  
