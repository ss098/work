<template>
    <div>
        <div class="is-clipped">
            <navbar></navbar>
            <div class="container">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .container {
        padding: 1rem;
    }
</style>
<script>
    import Navbar from "./components/layout/header.vue"

    export default {
        components: {
            Navbar
        }
    }
</script>
