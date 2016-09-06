<template>
    <div>
        <vm-new-handler
            :guilds="guilds"
        ></vm-new-handler>
        <vm-handler
            v-for="handler in handlers"
            :handler="handler"
            :guilds="guilds"
        >
        </vm-handler>
    </div>
</template>
<script>
    import _ from 'lodash'
    import vmHandler from './Handler.vue'
    import vmNewHandler from './NewHandler.vue'
    export default{
        components: {vmNewHandler, vmHandler},
        data(){
            return {
                guilds:[],
                handlers: [],
                processing: false
            }
        },
        ready(){
            this.loadGuilds()
            this.loadHandlers()
        },
        methods: {
            loadHandlers(){
                this.processing = true
                this.$http.get('dispatcher/handlers').then(
                    (response) => {
                        this.processing = false
                        this.handlers = response.json().data
                    },
                    () => {
                        this.processing = false
                    },
                )
            },

            loadGuilds(){
                this.$set('guilds', [])
                this.$http.get('dispatcher/guilds').then(
                    response => {
                        this.$set('guilds', response.json()['data'])
                    },
                    () => {
                        alert('Всё плохо')
                    }
                )
            },
        }
    }
</script>
