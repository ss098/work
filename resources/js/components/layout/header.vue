<template>
    <nav class="tabs is-centered">
        <ul>
            <li :class="{'is-active': name === 'index'}">
                <router-link :to="{name: 'index'}">
                    Work
                </router-link>
            </li>

            <li v-if="name === 'recycle'">
                <router-link :to="{name: 'recycle_overview', params: {id: $route.params.id}}">
                    表单统计
                </router-link>
            </li>
        </ul>
    </nav>
</template>
<script>
    export default {
        computed: {
            name: function () {
                return this.$route.name
            }
        }
    }
</script>
