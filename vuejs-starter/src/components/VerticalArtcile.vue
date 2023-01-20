<script setup>
const props = defineProps({
    reversed: {
        type: Boolean,
        default: false
    }
})
</script>
<template>
    <div class="px-32">
        <div class="flex flex-col-reverse md:flex-row-reverse md:space-x-reverse space-x-4 max-h-[32rem]"
            v-show="reversed">
            <div class="w-full md:w-1/2 h-full">
                <slot name="image" />
            </div>
            <div class="w-full md:w-1/2 h-full flex flex-col">
                <slot name="title" />
                <slot name="content" />
            </div>
        </div>
        <div class="flex flex-col md:flex-row space-x-4" v-show="!reversed">
            <div class="w-full md:w-1/2">
                <slot name="image" />
            </div>
            <div class="w-full md:w-1/2">
                <slot name="title" />
                <slot name="content" />
            </div>
        </div>
    </div>
</template>