<template>
    <div class="columns is-centered">
        <loading v-if="loading"></loading>
        <div v-else class="column is-two-thirds">
            <h2 class="subtitle has-text-centered">
                表单统计
            </h2>

            <div class="field">
                <label class="checkbox">
                    <input v-model="display_image" type="checkbox">
                    显示图片
                </label>

                <div v-if="records" class="is-pulled-right">
                    共 {{ records.length }} 条数据
                </div>
            </div>

            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                <tr>
                    <th width="96">姓名</th>
                    <th width="96">学号</th>
                    <th width="96">图片数量</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="record in records">
                        <td>{{ record.name }}</td>
                        <td>{{ record.code }}</td>
                        <td>{{ record.attachment.length }}</td>
                        <td v-if="display_image" v-for="attachment in record.attachment">
                            <img :src="`/recycle/attachment?id=${attachment.id}`" >
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="field">
                <div class="control is-expanded">
                    <a :href="`/recycle/export?id=${id}`" class="button is-link">
                        导出
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import swal from "sweetalert"

    export default {
        data: () => {
            return {
                records: null,
                loading: true,
                display_image: false
            }
        },
        methods: {
            get_records: function () {
                this.loading = true
                const id = this.id
                axios.get("/recycle/overview", {
                    params: {
                        id: id
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
            }
        },
        computed: {
            id: function () {
                return this.$route.params.id
            }
        },
        watch: {
            id: function () {
                this.get_records()
            }
        },
        mounted: function () {
            this.get_records()
        }
    }
</script>
