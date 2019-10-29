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
        },
        mounted: function () {
            axios.get("/notice").then(response => {
                console.log(response)
                if (response.data.enable) {
                    swal({
                        title: response.data.title,
                        text: response.data.text,
                        icon: response.data.icon
                    })
                }
            })
        }
    }
</script>
