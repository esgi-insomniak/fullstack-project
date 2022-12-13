<script>
export default {
    name: 'home',
    data() {
        return {
            username: '',
            password: '',
            error: ''
        }
    },
    methods: {},
    components: {}
}
</script>

<template>
    <div class="w-full h-screen">
      <h1 class="text-green-400">Home</h1>
      <button class="bg-green-400 text-white px-4 py-2 rounded">Logout</button>
    </div>
</template>