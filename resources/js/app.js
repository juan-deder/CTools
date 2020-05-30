require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import vuetify from './plugins/vuetify'

Vue.use(VueRouter)

import routes from './routes'

const app = new Vue({
    el: '#app',

    router: new VueRouter(routes),
    vuetify,

    data: {
        user: null,

        registerDialog: false,
        validRegister: null,
        registerLoading: false,
        registerPassVisible: false,
        registerFields: {},
        registerEmailError: null,
        registerRules: {
            email: [
                v => !!v || 'Correo requerido',
                v => /.+@.+\..+/.test(v) || 'Correo inválido'
            ],
            name: [
                v => !!v || 'Nombres requeridos',
            ],
            last_name: [
                v => !!v || 'Apellidos requeridos',
            ],
            password: [
                v => !!v || 'Contraseña requerida',
                v => (v && v.length > 7) || 'Mínimo 8 caracteres',
            ],
            password_confirmation: [
                v => !!v || 'Confirma la contraseña',
            ],
        },

        loginDialog: false,
        validLogin: null,
        loginLoading: false,
        loginPassVisible: false,
        loginFields: {},
        loginError: null,
        loginNameRules: [v => !!v || 'Correo requerido'],
        loginPassRules: [v => !!v || 'Contraseña requerida'],
    },

    created() {
        axios.get('sanctum/csrf-cookie')

        this.getUser()
    },

    computed: {
        password_confirmation () {
            if (this.registerFields.password_confirmation != this.registerFields.password &&
                this.registerFields.password_confirmation !== undefined)
                return 'No coincide'

            return null
        }
    },

    methods: {
        getUser () {
            axios.get('api/user')
                .then(({data}) => this.user = data)
                .catch(error => this.user = null)
        },

        register() {
            if (this.$refs.registerForm.validate()) {
                this.registerLoading = true
                this.registerEmailError = null
                axios.post('api/register', this.registerFields)
                    .then(response => {
                        this.getUser()
                        this.$refs.registerForm.reset()
                        this.registerDialog = null
                    })
                    .catch(error => {
                        this.registerFields.password = this.registerFields.password_confirmation = null
                        this.$refs.registerForm.resetValidation()
                        this.registerEmailError = error.response.data.errors.email
                    })
                    .finally(() => this.registerLoading = false)
            }
        },

        login () {
            if (this.$refs.loginForm.validate()) {
                this.loginLoading = true
                this.loginError = null
                axios.post('api/login', this.loginFields)
                    .then(response => {
                        this.getUser()
                        this.$refs.loginForm.reset()
                        this.loginDialog = false
                    })
                    .catch(error => {
                        this.loginFields.password = null
                        this.$refs.loginForm.resetValidation()
                        this.loginError = error.response.data.errors.email
                    })
                    .finally(() => this.loginLoading = false)
            }
        },

        logout () {
            axios.post('api/logout').then(response => this.user = null)
        }
    }
})
