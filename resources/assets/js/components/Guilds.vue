<template>
    <div>
        <div class="control is-grouped">
            <p class="control">
                <button
                    class="button is-primary is-icon"
                    @click="loadGuilds"
                    :class="{'is-loading':processing}"
                >
                    <i class="fa fa-refresh"></i>
                </button>
            </p>
            <p class="control">
                <a class="button is-success"
                   target="_blank"
                   href="{{addBot}}">
                    Add Bot to guild
                </a>
            </p>
        </div>
        <div transition="routeExpand" v-for="guild in guilds" class="columns">
            <div class="column is-1">
                <div class="icon-guild"
                >
                    <img
                        v-if="guild.icon !== null"
                        v-bind:src="guild.icon"
                    >
                   <span
                       v-else
                   >
                       {{guild.name.charAt(0).toUpperCase()}}
                   </span>

                </div>
            </div>
            <div class="column is-2" v-text="guild.name"></div>
            <div class="column" :class="{indicator:guild.bot}">
                <i class="fa fa-circle" title=""></i>
                <span v-text="guild.bot ? 'Bot endabled': 'Bot disabled'"></span>
            </div>
        </div>
        <section transition="wwump" class="section has-text-centered" v-if="guilds.length === 0 && !processing">
            <img src="/images/wwampus.png">
            <p> No guilds present </p>
        </section>
    </div>
</template>
<script>
    export default{
        components: {},
        data(){
            return {
                guilds: [],
                processing: false,
                addBot: ''
            }
        },
        ready(){
            this.loadGuilds()
            this.generateLink()
        },
        methods: {
            loadGuilds(){
                this.$set('guilds', [])
                if(this.processing) return
                this.processing = true
                this.$http.get('dispatcher/guilds').then(
                    (response) => {
                        this.$set('guilds', response.json()['data'])
                        this.processing = false
                    },
                    () => {
                        this.processing = false
                    }
                )
            },
            generateLink(){
                let appId = document.querySelector('meta[name="app_id"]').getAttribute('content')
                this.addBot = 'https://discordapp.com/oauth2/authorize?scope=bot&client_id=' + appId
            }
        }
    }
</script>
