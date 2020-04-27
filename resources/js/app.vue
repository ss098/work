<template>
    <main class="is-clipped">
        <navbar></navbar>

        <router-view></router-view>
    </main>
</template>
<script>
    import Navbar from "./components/layout/header.vue"

    export default {
        components: {
            Navbar
        }
    }
</script>
