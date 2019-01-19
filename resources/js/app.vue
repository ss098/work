<template>
    <div>
        <div class="container is-clipped">
            <navbar></navbar>
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
