import Vue from 'vue'
import vmDispatcher from  './components/Dispatcher.vue'
import {getCookie} from './helpers.js'

var VueResource = require('vue-resource');
Vue.use(VueResource);

export default new Vue({
    el: 'body',
    components:{vmDispatcher},
});

Vue.http.interceptors.push((request, next) => {
  request.headers['X-XSRF-TOKEN'] = getCookie('XSRF-TOKEN')
  next()
})
