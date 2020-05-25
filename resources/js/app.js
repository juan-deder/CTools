import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import DashboardPlugin from '@/plugins/blackDashboard'

window.axios = axios

Vue.use(VueRouter)
Vue.use(DashboardPlugin)

import routes from './routes'

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),

    data: {
        user: null
    },

    created() {
        axios.get('sanctum/csrf-cookie')

        this.getUser()
    },

    methods: {
        getUser () {
            axios.get('api/user')
                .then(({data}) => this.user = data)
                .catch(error => this.user = null)
        },

        login () {
            axios.post('api/login', {email: 'q@q', password: 'qwerqwer'})
                .then(response => this.getUser())
                .catch(error => { this.user  = null })
        },

        logout () {
            axios.post('api/logout').then(response => this.user = null)
        }
    }
})
