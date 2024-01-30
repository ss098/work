<template>
    <div class="columns is-centered container-horizontal">
        <loading v-if="loading"></loading>

        <div v-else class="column is-one-quarter has-text-centered">
            <h2 class="subtitle">
                {{ detail.name }}
            </h2>

            <article class="message" v-if="notice.text">
                <div class="message-body">
                    {{ notice.text }}
                </div>
            </article>

            <div class="field">
                <label class="label" for="name">姓名</label>
                <div class="control">
                    <input id="name" v-model="recycle.name" autofocus class="input" type="text">
                </div>
            </div>
            <div class="field">
                <label class="label" for="code">学号</label>
                <div class="control">
                    <input id="code" v-model="recycle.code" class="input" type="text">
                </div>
            </div>

            <div class="field">
                <label class="label">附件</label>
                <div class="control">
                    <div class="file has-name is-right is-fullwidth">
                        <label class="file-label">
                            <input @change="attachment_change" ref="attachment" class="file-input" type="file" multiple>
                            <span class="file-cta">
                                <span class="file-icon">
                                    <img src="../../../../storage/app/image/upload.png" alt="上传">
                                </span>
                                <span class="file-label">
                                    选择文件
                                </span>
                            </span>
                            <span class="file-name">
                                <span v-if="recycle.attachment.length > 0">
                                    已选择 {{ recycle.attachment.length }} 个文件
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
                <p class="help">
                    如无法选择附件，使用系统浏览器打开此页面。
                </p>
            </div>

            <button @click="post_record" :class="{'button is-link is-fullwidth': true, 'is-loading': post_loading}">
                提交
            </button>

            <div v-for="(attachment, index) in recycle.attachment">
                <div class="box">
                    <div class="columns has-text-centered">
                        <div class="column">
                            <p>{{ attachment.name }}（{{ filesize(attachment.size) }}）</p>
                        </div>
                        <div class="buttons has-addons is-centered">
                            <button @click="recycle.attachment.splice(index, 1)" class="button is-danger">删除</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .box {
        margin: 1rem 0;
    }
</style>
<script>
    import swal from "sweetalert"
    import { filesize } from "filesize"
    import ImageCompressor from "image-compressor.js"

    export default {
        data: () => {
            return {
                detail: null,
                recycle: {
                    name: "", // 姓名
                    code: "", // 学号
                    attachment: []
                },
                loading: true,
                post_loading: false,
                filesize: filesize
            }
        },
        methods: {
            get_detail: function () {
                this.loading = true
                const id = this.id
                axios.get("/detail", {
                    params: {
                        id: id
                    }
                }).then(response => {
                    if (response.data.success) {
                        let detail = response.data.detail

                        if (detail.id === parseInt(id)) {
                            this.detail = detail

                            this.loading = false
                        }
                    } else {
                        swal({
                            text: "表单不存在",
                            icon: "error",
                            timer: 2000
                        })

                        this.$router.push({name: "index"})
                    }
                })
            },
            attachment_change: function () {
                const files = this.$refs.attachment.files

                if (files.length > 0) {
                    let attachment = this.recycle.attachment

                    for (let i = 0; i < files.length; i++) {
                        const file = files[i]

                        if (file.size <= 1024 * 1024 * 16) {
                            const callback = result => {
                                const reader = new FileReader()

                                reader.onload = e => {
                                    attachment.push({
                                        name: file.name,
                                        size: file.size,
                                        data: e.target.result,
                                        type: file.type
                                    })
                                }

                                reader.readAsDataURL(result)
                            }

                            if (file.type.startsWith("image")) {
                                new ImageCompressor(file, {
                                    quality: 0.6,
                                    convertSize: 256 * 1024,
                                    success: (result) => callback(result)
                                })
                            } else {
                                callback(file)
                            }
                        } else {
                            swal({
                                text: "请勿上传超过 16 MByte 的附件",
                                timer: 2000
                            })
                        }
                    }

                    this.recycle.attachment = attachment
                }
            },
            post_record: function () {
                const recycle = this.recycle

                if (!recycle.name) {
                    swal({
                        text: "姓名空缺",
                        timer: 2000
                    })
                } else if (!recycle.code) {
                    swal({
                        text: "学号空缺",
                        timer: 2000
                    })
                } else if (!this.post_loading) {
                    this.post_loading = true

                    axios.post("/recycle", {
                        id: this.detail.id,
                        recycle: recycle
                    }).then(response => {
                        swal({
                            text: "提交成功",
                            icon: "success"
                        })
                    }).catch(error => {
                        swal({
                            text: "提交失败",
                            icon: "error"
                        })
                    }).finally(() => {
                        this.post_loading = false
                    })
                }
            }
        },
        computed: {
            id: function () {
                return this.$route.params.id
            },
            notice: function () {
                return {
                    text: process.env.MIX_DETAIL_TEXT
                }
            }
        },
        watch: {
            id: function () {
                this.get_detail()
            }
        },
        mounted: function () {
            this.get_detail()
        }
    }
</script>
