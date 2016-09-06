<template>
    <div transition="routeExpand" class="columns">
        <div class="column is-5">
            <p class="control has-addons">
                <vm-select tabindex="-1" class="input is-expanded" v-text="hook"></vm-select>
                <vm-copy :text="hook"></vm-copy>
            </p>
        </div>
        <div class="column is-"> {{ name }}</div>
        <div class="column is-5">
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
</template>
<script>
    import _ from 'lodash'
    import vmCopy from './Copy.vue'
    import vmSelect from './Select.vue'
    import {getCookie} from '../helpers.js'
    export default {
        components:{vmSelect, vmCopy},
        props:['data'],
        data(){
            return _.merge({
                deleteIsOpen: false,
                deleteProcessing: false,
            }, this.data);

        },
        methods:{
            openDelete(){
                this.deleteIsOpen = true
            },
            closeDelete(){
                this.deleteIsOpen = false
            },
            remove(){
                this.deleteProcessing = true
                this.$http.delete('/dispatcher/routes/'+this.id,
                    {headers: {'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')}}
                    ).then(response => {
                        let index = _.findIndex(this.$parent.routes, {'id': this.id})
                        this.$parent.routes.splice(index, 1)
                        this.deleteProcessing = true
                }, response => {
                    this.deleteProcessing = true
                    alert('Всё плохо! Зырь в консоль.')
                });
            }
        }
    }
</script>