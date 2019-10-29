<template>
    <nav class="tabs is-centered">
        <ul>
            <li :class="{'is-active': name === 'index'}">
                <router-link :to="{name: 'index'}">
                    Work
                </router-link>
            </li>

            <li v-if="id" :class="{'is-active': name === 'recycle'}">
                <router-link :to="{name: 'recycle', params: {id: id}}">
                    表单
                </router-link>
            </li>

            <li v-if="id" :class="{'is-active': name === 'recycle_overview'}">
                <router-link :to="{name: 'recycle_overview', params: {id: id}}">
                    统计
                </router-link>
            </li>

            <li :class="{'is-active': name === 'guide'}">
                <router-link :to="{name: 'guide'}">
                    指南
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
            },
            id: function () {
                return this.$route.params.id
            }
        }
    }
</script>
