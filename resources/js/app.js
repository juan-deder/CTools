import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
window.axios = axios

Vue.use(VueRouter)

import routes from './routes'

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    csrf_token: null,
    created() {
        if(! this.csrf_token)
            return axios.get('sanctum/csrf-cookie')
                .then(response => {
                    this.token = response.data
                })
    }
})
