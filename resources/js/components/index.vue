<template>
    <div class="columns is-centered container-horizontal">
        <div class="column is-one-quarter">
            <article class="message" v-if="notice.enable === 'true'">
                <div v-if="notice.title" class="message-header">
                    <p>{{ notice.title }}</p>
                </div>
                <div class="message-body">
                    {{ notice.text }}
                </div>
            </article>

            <label for="recycle_name" class="label">为表单起一个名字：</label>

            <div class="field is-grouped">
                <div class="control is-expanded">
                    <input id="recycle_name" @keydown.enter="create" v-model="name" autofocus class="input" type="text"
                           placeholder="新表单">
                </div>
                <div class="control">
                    <a @click="create" :class="{'button is-link': true, 'is-loading': loading}">
                        确定
                    </a>
                </div>
            </div>

            <nav v-if="forms && forms.length > 0" class="panel">
                <router-link :to='{name: "recycle", params: {id: item.id}}' v-for="item in forms" :key="item.id"
                             :class="{
                    'panel-block': true,
                    'is-active': item.record_count > 0
                }">
                    <span class="panel-icon">
                        {{ item.record_count }}
                    </span>
                    {{ item.name }}
                </router-link>
            </nav>

            <section class="section content has-text-centered">
                <p>Copyright &copy; {{ year }} 小可爱</p>
                <p>项目在 <a href="https://github.com/ss098/work">GitHub</a> 提供开放源代码版本</p>

                <div v-if="analytics_enable">
                    <p>Simple Analytics 提供隐私友好型数据分析服务</p>
                    <a :href="`https://simpleanalytics.com/${domain}`"
                       referrerpolicy="origin" target="_blank" rel="noreferrer noopener">
                        <img :src="`https://simpleanalyticsbadge.com/${domain}?background=white&text=3273dc&logo=3273dc`" referrerpolicy="no-referrer"
                             crossorigin="anonymous" alt="Simple Analytics"/>
                    </a>
                </div>
            </section>
        </div>
    </div>
</template>
<style scoped>
    .field {
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
                forms: [],
                analytics_enable: process.env.MIX_SIMPLE_ANALYTICS_ENABLE,
                domain: document.domain
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
            },
            notice: function () {
                return {
                    enable: process.env.MIX_NOTICE_ENABLE,
                    title: process.env.MIX_NOTICE_TITLE,
                    text: process.env.MIX_NOTICE_TEXT
                }
            }
        },
        mounted: function () {
            this.get_forms()

        }
    }
</script>
