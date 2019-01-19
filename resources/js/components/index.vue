<template>
    <div class="columns is-centered">
        <div class="column is-one-quarter has-text-centered">
            <h2 class="subtitle">简化教育信息收集过程</h2>
            <p>帮助你轻松完成教育数据收集与整理，例如劳民伤财费神的青年大学习截图收集</p>
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

            <p>Copyright &copy; 2019 MicroCute</p>
        </div>
    </div>
</template>
<style scoped>
    .field {
        margin-top: 4rem;
        user-select: none;
    }

    h2 {
        margin-top: 4rem;
    }

    p {
        margin-top: 4rem;
    }
</style>
<script>
    import swal from "sweetalert"

    export default {
        data: () => {
            return {
                name: "",
                loading: false
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
            }
        }
    }
</script>
