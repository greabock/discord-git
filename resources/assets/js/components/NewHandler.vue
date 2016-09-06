<template>
    <div>
      <div class="columns">
        <div class="column is-5">
          <label class="label">
            Guilds
          </label>
          <vm-multi-select
            placeholder=""
            select-label=""
            selected-label=""
            deselect-label=""
            key="id"
            label="name"
            :options="guildsHasBot"
            :selected="newHandler.guilds"
            :multiple="true"
            @update="updateSelectedGuilds"
          ></vm-multi-select>
        </div>
        <div class="column is-5">
          <label class="label">Routes</label>
          <vm-multi-select
            placeholder=""
            select-label=""
            selected-label=""
            deselect-label=""
            key="id"
            label="name"
            :options="routes"
            :selected="newHandler.routes"
            :multiple="true"
            @update="updateSelectedRoutes"
          ></vm-multi-select>
        </div>
        <div class="column is-2">
          <label class="label">Type</label>
          <div class="columns">
            <div class="column">
              <vm-multi-select
                selected-label=""
                deselect-label=""
                select-label=""
                placeholder="Type"
                :selected="newHandler.type"
                :options="types"
                @update="updateType"
              ></vm-multi-select>
            </div>
            <div class="column">
              <button
                class="button is-success is-icon"
                :class="{'is-loading': processing}"
                @click="store"
              ><span>Save</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div transition="wwump" v-if="newHandler.type === 'json'">
        <label class="label" for="template">Template</label>
        <p class="control">
            <textarea
              style="height:190px"
              v-model="newHandler.template"
              id="template"
              class="textarea"
              placeholder="Define your template"
            ></textarea>
        </p>
      </div>
    </div>
</template>
<script>
    import _ from 'lodash'
    import vmMultiSelect from 'vue-multiselect'
    import {getCookie} from '../helpers.js'
    export default{
        components:{vmMultiSelect},
        props:['guilds'],
        data(){
            return {
                processing: false,
                types: ['as is', 'json'],
                routes: [],
                newHandler: {
                    guilds: [],
                    routes: [],
                    type: 'as is',
                    template: ''
                }
            }
        },
        ready(){
            console.log(this.guilds)
            this.loadRoutes()
        },

        computed: {
            guildsHasBot(){
                return _.filter(this.guilds, (guild) =>{
                    return guild.bot === true
                })
            }
        },

        methods: {
            loadRoutes(){
                this.$http.get('/dispatcher/routes').then((response) => {
                    this.$set('routes', response.json())
                }, response => {
                    alert('Всё плохо! Зырь в консоль.')
                });
            },
            updateSelectedRoutes(newSelected) {
                this.newHandler.routes = newSelected
            },
            updateSelectedGuilds(newSelected) {
                this.newHandler.guilds = newSelected
            },
            updateType(newSelected) {
                this.newHandler.type = newSelected
            },
            resetFields(){
              this.updateSelectedGuilds([])
              this.updateSelectedRoutes([])
              this.updateType('as is')
              this.newHandler.template = ''
            },
            store(){
                this.processing = true
                let data = {}
                data.channels = _.map(this.newHandler.guilds, guild => {
                    return guild.id
                })
                data.type     = this.newHandler.type
                data.template = this.newHandler.template
                data.routes   = _.map(this.newHandler.routes, route => {
                    return route.id
                })

                this.$http.post('dispatcher/handlers', data, {
                }).then(response => {
                    this.processing = false
                    this.$parent.handlers.push(response.json()['data'])
                    this.resetFields()
                }, response => {
                    this.processing = false
                    alert('Всё плохо! Зырь в консоль.')
                })
            }
        }
    }
</script>
