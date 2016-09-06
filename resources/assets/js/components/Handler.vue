<template>
    <div class="columns">
        <div class="column is-5">
            <div v-if="guilds.length !== 0">
                    <span
                        class="tag is-primary"
                        v-for="channel in handler.channels"
                    >{{getGuildName(channel)}}</span>
            </div>
        </div>
        <div class="column is-5">
                <span
                    class="tag is-primary"
                    v-for="route in handler.routes"
                >{{route.name}}</span>
        </div>
        <div class="column is-2">
            <div class="columns">
                <div class="column">
                    <span class="title is-5" v-text="handler.type"></span>
                </div>
                <div class="column">
                    <p class="control" :class="{'has-addons': deleteIsOpen}">
                        <button
                            class="button is-danger is-outlined is-icon"
                            @blur="closeDelete"
                            @click="openDelete"
                            :class="{'is-loading': deleteProcessing}"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                        <button transition="fade"
                                v-show="deleteIsOpen"
                                class="button is-danger"
                                @mousedown="remove"
                        >
                            Delete
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import _ from 'lodash'
    import {getCookie} from  '../helpers.js'
    export default {
        props: ['handler', 'guilds'],
        data(){
            return {
                deleteProcessing: false,
                deleteIsOpen: false,
            }
        },
        methods: {
            getGuildName(id){
                return _.find(this.guilds, {id}).name
            },
            openDelete(){
                this.deleteIsOpen = true
            },
            closeDelete(){
                this.deleteIsOpen = false
            },
            remove(){
                this.deleteProcessing = true
                this.$http.delete('/dispatcher/handlers/' + this.handler.id,
                    {headers: {'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')}}
                ).then((response) => {
                    let index = _.findIndex(this.$parent.routes, {'id': this.handler.id})
                    this.$parent.handlers.splice(index, 1)
                    this.deleteProcessing = false
                }, (response) => {
                    this.deleteProcessing = false
                    alert('Всё плохо! Зырь в консоль.')
                });
            }
        }
    }
</script>