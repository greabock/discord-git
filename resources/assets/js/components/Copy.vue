<template>
    <button title="copy to clipboard"  :class="{'is-loading': processing}" class="button is-primary is-outlined is-icon" @click="copy(text)">
        <i class="fa fa-clipboard"></i>
    </button>
</template>
<script>
    import copy from 'copy-to-clipboard'

    export default {
        data(){
            return {
                processing: false
            }
        },
        props: ['text'],
        methods: {
            copy(text){
                copy(text)
                this.processing = true
                setTimeout(()=>{
                    this.processing = false
                }, 200)
            },
        }
    }
</script>