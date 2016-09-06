<template>
    <p class="control has-addons">
        <input class="input"
               v-model="newRouteName"
               type="text"
               placeholder="Enter new route name"
        >
        <button
            class="button is-success"
            @click="addRoute"
            :class="{'is-loading': processing}"
        >Add
        </button>
    </p>
</template>
<script>
    import {getCookie} from '../helpers.js'
    export default {
        data(){
            return {
                processing: false,
                newRouteName: ''
            }
        },
        methods: {
            addRoute(){
                this.processing = true
                this.$http.post('/dispatcher/routes', {
                    "name": this.newRouteName
                }).then((response) => {
                    this.newRouteName = ''
                    this.$parent.routes.push(response.json())
                    this.processing = false
                }, response => {
                    this.processing = false
                    alert('Всё плохо! Зырь в консоль.')
                });
            },
        }
    }
</script>