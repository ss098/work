<template>
    <div>
        <navbar></navbar>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import Navbar from "./components/layout/header.vue"

    export default {
        components: {
            Navbar
        }
    }
</script>
