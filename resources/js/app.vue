<template>
    <div>
        <div class="is-clipped">
            <navbar></navbar>

            <router-view></router-view>
        </div>
    </div>
</template>
<style scoped>
    .container {
        padding: 1rem;
    }
</style>
<script>
    import swal from "sweetalert"
    import Navbar from "./components/layout/header.vue"

    export default {
        components: {
            Navbar
        }
    }
</script>
