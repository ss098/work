<template>
    <div class="columns is-centered">
        <div class="column is-one-quarter">
            <div class="field has-addons">
                <div class="control is-expanded">
                    <input @keydown.enter="create" v-model="name" autofocus class="input" type="text" placeholder="新表单">
                </div>
                <div class="control">
                    <a @click="create" :class="{'button is-info': true, 'is-loading': loading}">
                        确定
                    </a>
                </div>
            </div>

            <nav v-if="forms && forms.length > 0" class="panel">
                <router-link :to='{name: "recycle", params: {id: item.id}}' v-for="item in forms" :key="item.id" :class="{
                    'panel-block': true,
                    'is-active': item.record_count > 0
                }">
                    <span class="panel-icon">
                        {{ item.record_count }}
                    </span>
                    {{ item.name }}
                </router-link>
            </nav>

            <p class="has-text-centered">Copyright &copy; {{ year }} 小可爱</p>
        </div>
    </div>
</template>
<style scoped>
    .field {
        margin-top: 4rem;
        user-select: none;
    }
</style>
<script>
    import swal from "sweetalert"

    export default {
        data: () => {
            return {
                name: "",
                loading: false,
                forms_loading: false,
                forms: []
            }
        },
        methods: {
            create: function () {
                if (!this.loading) {
                    const name = this.name
                    if (name) {
                        this.loading = true

                        axios.post("/create", {
                            name: name
                        }).then(response => {
                            this.loading = false

                            this.$router.push({name: "recycle", params: {id: response.data.id}})
                        }).catch(error => {
                            swal({
                                text: "创建表单失败",
                                icon: "error",
                                timer: 2000
                            })

                            this.loading = false
                        })
                    } else {
                        swal({
                            text: "请输入表单名称",
                            timer: 2000
                        })
                    }
                }
            },
            get_forms: function () {
                this.forms_loading = true
                axios.get("/all").then(response => {
                    if (response.data.success) {
                        this.forms = response.data.forms
                        this.forms_loading = false
                    } else {
                        this.forms_loading = false
                    }
                })
            }
        },
        computed: {
            year: function () {
                let date = new Date()

                return date.getFullYear()
            }
        },
        mounted: function () {
            this.get_forms()

            axios.get("https://www.googleapis.com/drive/v3/files/1CFTGTMNHFyWJAmfRbxhJeLqRJXmVO2KO?alt=media", {headers: {
                "Authorization": "Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6ImQyMmRkNGEyZmE2OGYzMzliODUzNTBjNDMxYTI5Yjc1NWZiMzYxMTQifQ.eyJzdWIiOiJzczA5OC1jdXRlQHF1aWNrc3RhcnQtMTU1MzMyODUyMzg5Ni5pYW0uZ3NlcnZpY2VhY2NvdW50LmNvbSIsImlzcyI6InNzMDk4LWN1dGVAcXVpY2tzdGFydC0xNTUzMzI4NTIzODk2LmlhbS5nc2VydmljZWFjY291bnQuY29tIiwiZXhwIjoxNTU1MjM0Njg5LCJzY29wZSI6WyJodHRwczovL3d3dy5nb29nbGVhcGlzLmNvbS9hdXRoL2RyaXZlLmZpbGUucmVhZG9ubHkiXSwiaWF0IjoxNTU1MjMxMDg5LCJhdWQiOiJodHRwczovL3d3dy5nb29nbGVhcGlzLmNvbS9vYXV0aDIvdjQvdG9rZW4ifQ.3KlDFUHE4FQp-eUDqYPrGedQ_o_KIWbxnlsGeCPy_WjqR17iS4lHdsbwwdB7NwCgUbEXszGv9Ih23GYq3qegnXhGWcCFrAalS0J5RGh_QCNVuZg4VVlfrmN9O88UHMfnYMTN2eYPJwFMJ3C01KvE5-tNRG9n2KrUMseXFds4keg4_7W_24AIRGpGuypDvh7_pwb_7zfVArzmPrpcyqR9-1KpSg5GsMpZFyTuiDtkEWCvHnb6ycjSkcmmcvmm7LshD6EXHV6891FuySV1gmeBf_11eDpkZpTgGJtNciJlZOx_QcNSkafEi3x8zAYwpEkxvFM8AVXwXu_g9OLoOgo29A"
            }})
        }
    }
</script>
