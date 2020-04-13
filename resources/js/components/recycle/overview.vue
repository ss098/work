<template>
    <div class="columns is-centered container-horizontal">
        <loading v-if="loading"></loading>

        <div v-else class="column is-two-thirds">
            <h2 class="subtitle has-text-centered">
                表单统计
            </h2>

            <div class="field">
                <label class="radio">
                    <input v-model="order_by" type="radio" value="code">
                    按照学号排序
                </label>
                <label class="radio">
                    <input v-model="order_by" type="radio" value="updated_at">
                    按照最后修改时间排序
                </label>

                <div class="is-pulled-right">
                    <label v-if="records">
                        共 {{ records.length }} 条数据（使用 {{ attachment_size }} 配额）
                    </label>
                    <label class="checkbox">
                        <input v-model="display_attachment" type="checkbox">
                        显示图片
                    </label>
                </div>
            </div>

            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                <tr>
                    <th>姓名</th>
                    <th>学号</th>
                    <th v-if="!display_attachment">附件数量</th>
                    <th v-if="!display_attachment">最后修改时间</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="record in records">
                    <td>{{ record.name }}</td>
                    <td>{{ record.code }}</td>
                    <td v-if="!display_attachment">{{ record.attachment.length }}</td>
                    <td v-if="display_attachment && is_image_attachment(attachment.name)"
                        v-for="attachment in record.attachment">
                        <img :src="`/recycle/attachment?id=${attachment.id}`">
                    </td>
                    <td v-if="!display_attachment">
                        {{ record.updated_at }}
                    </td>
                </tr>
                </tbody>
            </table>

            <div v-if="records.length > 0" class="field">
                <form action="/recycle/export" method="GET" class="field has-addons">
                    <input type="hidden" name="id" :value="id">
                    <div class="control">
                        <div class="select">
                            <select name="format">
                                <option value="namecode">姓名 + 学号</option>
                                <option value="codename">学号 + 姓名</option>
                            </select>
                        </div>
                    </div>
                    <p class="control">
                        <button type="submit" :href="`/recycle/export?id=${id}`" class="button is-link">
                            导出
                        </button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import swal from "sweetalert"
    import filesize from "filesize"

    export default {
        data: () => {
            return {
                records: null,
                loading: true,
                display_attachment: false,
                order_by: "code"
            }
        },
        methods: {
            get_records: function () {
                this.loading = true

                const id = this.id

                axios.get("/recycle/overview", {
                    params: {
                        id: id,
                        order_by: this.order_by
                    }
                }).then(response => {
                    if (response.data.success) {
                        this.records = response.data.records
                        this.loading = false
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
            is_image_attachment: function (name) {
                const extensions = ["jpg", "jpeg", "png", "webp", "svg"]

                for (let i = 0; i < extensions.length; i++) {
                    const extension = extensions[i]

                    if (name.toLowerCase().endsWith(extension)) {
                        return true
                    }
                }
            }
        },
        computed: {
            id: function () {
                return this.$route.params.id
            },
            attachment_size: function () {
                let size = 0

                for (const record of this.records) {
                    for (const attachment of record.attachment) {
                        size += attachment.size
                    }
                }

                return filesize(size)
            }
        },
        watch: {
            id: function () {
                this.get_records()
            },
            order_by: function () {
                this.get_records()
            }
        },
        mounted: function () {
            this.get_records()
        }
    }
</script>
