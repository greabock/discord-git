<template>
    <div class="box">
        <div class="tabs">
            <ul>
                <li :class="{'is-active':currentTab == 'guilds'}"  @click="setTab('guilds')"><a> Guilds </a>
                <li :class="{'is-active':currentTab == 'routes'}" @click="setTab('routes')"><a> Routes </a>
                <li :class="{'is-active':currentTab == 'handlers'}" @click="setTab('handlers')"><a> Handlers </a>
            </ul>
        </div>
        <vm-routes transition="fade" v-if="currentTab === 'routes'"></vm-routes>
        <vm-guilds transition="fade" v-if="currentTab === 'guilds'"></vm-guilds>
        <vm-handlers transition="fade" v-if="currentTab === 'handlers'"></vm-handlers>
    </div>
</template>
<script>
    import vmRoutes from './Routes.vue'
    import vmGuilds from './Guilds.vue'
    import vmHandlers from './Handlers.vue'

    export default {
        components: {vmRoutes, vmGuilds, vmHandlers},
        data(){
            return {
                currentTab:'guilds'
            }
        },
        methods: {
            setTab(tab){
                this.currentTab = tab
            }
        }
    }
</script>