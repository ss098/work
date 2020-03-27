<template>
    <div>
        <div class="is-clipped">
            <navbar></navbar>

            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import swal from "sweetalert"
    import Navbar from "./components/layout/header.vue"

    export default {
        components: {
            Navbar
        }
    }
</script>
