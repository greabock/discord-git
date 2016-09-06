<template>
    <span v-el:select @click="select"></span>
</template>
<script>
    import {select} from '../helpers.js'
    export default {
        methods:{
            select(){
                select(this.$els.select)
            }
        }
    }
</script>