<template>
    <div>
        <vm-new-route></vm-new-route>
        <vm-route v-for="route in routes" :data="route"></vm-route>
        <section transition="wwump" class="section has-text-centered" v-if="routes.length === 0">
        <img src="/images/wwampus.png">
        <p> No routes present </p>
    </section>
    </div>
</template>
<script>
    import _ from 'lodash'
    import vmRoute from './Route.vue'
    import vmNewRoute from './NewRoute.vue'
    export default {
        components: {vmRoute, vmNewRoute},
        data(){
            return {
                routes: [],
            }
        },
        ready() {
            this.loadRoutes()
        },
        methods: {
            loadRoutes(){
                this.$http.get('/dispatcher/routes').then((response) => {
                    this.$set('routes', response.json())
                }, (response) => {
                    alert('Всё плохо! Зырь в консоль.')
                });
            }
        }
    }
</script>
<style>
    .wwump-transition{
        transition: all .3s ease;
        height: 230px;
        overflow: hidden;
    }
    .wwump-enter, .wwump-leave{
        padding: 0;
        margin: 0;
        height: 0;
    }
</style>