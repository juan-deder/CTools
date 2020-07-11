<template>
    <v-app>
        <v-navigation-drawer v-if="!homeActive && user" mini-variant-width="66" app width="220" permanent dark src="@/assets/pattern.png">
            <v-img src="@/assets/logo.png"></v-img>
            <v-list dense nav class="py-0" style="background: rgba(0, 0, 0, .3)">
                <v-list-item two-line class="px-0">
                    <avatar :user="user" wrapper="v-list-item-avatar" :props="{size: 50}"></avatar>
                    <v-list-item-content>
                        <v-list-item-title class="body-1">{{ user.name }}</v-list-item-title>
                        <v-list-item-subtitle>{{ user.last_name }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list dense nav>
                <v-list-item link to="/">
                    <v-list-item-icon><v-icon>mdi-home</v-icon></v-list-item-icon>
                    <v-list-item-title>Inicio</v-list-item-title>
                </v-list-item>
                <v-list-group eager prepend-icon="mdi-calendar-blank-multiple">
                    <template v-slot:activator>
                        <v-list-item-title>Planes</v-list-item-title>
                    </template>

                    <v-list-group no-action sub-group>
                        <template v-slot:activator>
                            <v-list-item-title>Mis planes</v-list-item-title>
                            <span class="caption">2</span>
                            <v-list-item-icon>
                                <v-icon>mdi-account-cowboy-hat</v-icon>
                            </v-list-item-icon>
                        </template>

                        <v-list-item>
                            <v-list-item-title>Home</v-list-item-title>
                            <v-list-item-icon>
                                <v-icon>mdi-home</v-icon>
                            </v-list-item-icon>
                        </v-list-item>
                    </v-list-group>

                    <v-list-group no-action sub-group>
                        <template v-slot:activator>
                            <v-list-item-title>Compartidos<br>conmigo</v-list-item-title>
                            <span class="caption">2</span>
                            <v-list-item-icon>
                                <v-icon>mdi-account-group-outline</v-icon>
                            </v-list-item-icon>
                        </template>

                        <v-list-item>
                            <v-list-item-title>Home</v-list-item-title>
                            <v-list-item-icon>
                                <v-icon>mdi-home</v-icon>
                            </v-list-item-icon>
                        </v-list-item>
                    </v-list-group>
                </v-list-group>
            </v-list>

            <v-list dense nav style="position:absolute;bottom:0;width:100%;">
                <v-list-item link @click="logout">
                    <v-list-item-icon><v-icon>mdi-logout</v-icon></v-list-item-icon>
                    <v-list-item-title>Cerrar sesión</v-list-item-title>
                </v-list-item>
                <v-list-group sub-group prepend-icon="mdi-cog" style="background:rgba(255,255,255,.1)">
                    <template v-slot:activator>
                        <v-list-item-title>Preferencias</v-list-item-title>
                    </template>

                    <v-list subheader nav dense rounded>
                        <v-list-item class="pl-2">
                            <v-list-item-icon><v-icon>mdi-google-translate</v-icon></v-list-item-icon>
                            <v-list-item-title>Idioma</v-list-item-title>
                        </v-list-item>
                        <v-list-item link @click="dark = !dark" class="pr-0 pl-2">
                            <v-list-item-icon>
                                <v-icon>{{ themeIcon }}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content style="border-radius:4px" class="pl-2 py-0"
                                                 :class="dark ? 'grey darken-4' : 'white'">
                                <v-list-item-subtitle class="d-flex" :class="dark ? ' white--text' : 'black--text'"
                                                      style="flex-basis:content;">
                                    Tema: <b>{{ dark ? 'Dark' : 'Light' }}</b>
                                </v-list-item-subtitle>
                                <v-switch background-color="red" v-model="dark" height="0" dense
                                          :loading="themeLoading"
                                          readonly>
                                </v-switch>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-list-group>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar v-else app dense height="85.2" class="purple" dark>
            <v-toolbar-title v-if="homeActive">
                <v-img width="220" src="./assets/logo.png"></v-img>
            </v-toolbar-title>
            <v-toolbar-items v-if="homeActive">
                <v-btn text to="/">Inicio</v-btn>
                <v-btn text to="/grids">CGrid</v-btn>
            </v-toolbar-items>
            <v-spacer></v-spacer>

            <template v-if="user">
                <avatar :props="{size: 35}" :user="user"></avatar>
                <v-btn class="mx-2" @click="logout">Salir</v-btn>
            </template>
            <template v-else>
                <v-dialog v-model="registerDialog" max-width="500" keydown overlay-opacity=".9">
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on" text>Registrarse</v-btn>
                    </template>
                    <v-card :loading="registerLoading">
                        <v-card-title class="white--text purple">
                            Registro
                            <v-spacer></v-spacer>
                            <v-btn dark @click="registerDialog = false" icon>
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-card-title>
                        <v-card-text>
                            <p class="mt-3 mb-0 text-center font-weight-bold">Ingresa con</p>
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-btn block height="48" class="pa-1 white--text" color="#f80019" rounded>
                                        <v-avatar class="float-left" color="pa-2 white" size="40">
                                            <v-img src="./assets/google.png" contain></v-img>
                                        </v-avatar>
                                        <v-spacer></v-spacer>
                                        Google
                                        <v-spacer></v-spacer>
                                    </v-btn>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-btn block height="48" class="pa-1 white--text" color="#464498" rounded @click="facebookLogin">
                                        <v-avatar class="float-left" color="pa-2 white" size="40">
                                            <v-img src="./assets/facebook.png" contain></v-img>
                                        </v-avatar>
                                        <v-spacer></v-spacer>
                                        Facebook
                                        <v-spacer></v-spacer>
                                    </v-btn>
                                </v-col>
                            </v-row>
                            <p class="mt-5 mb-0 text-center font-weight-bold">Crea una cuenta</p>
                            <v-form ref="registerForm" :value="validRegister">
                                <v-row no-gutters>
                                    <v-col cols=12 md="6">
                                        <v-text-field color="purple" v-model="registerFields.name"
                                                      label="Nombres" class="mt-0"
                                                      :rules="registerRules.name" required></v-text-field>
                                    </v-col>
                                    <v-col cols=12 md="6">
                                        <v-text-field color="purple" v-model="registerFields.last_name"
                                                      label="Apellidos" class="mt-0"
                                                      :rules="registerRules.last_name" required></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-text-field color="purple" type="email" v-model="registerFields.email"
                                              label="Correo electrónico" class="mt-0"
                                              :rules="registerRules.email" :error-messages="registerEmailError"
                                              validate-on-blur required></v-text-field>
                                <v-row no-gutters>
                                    <v-col cols=12 md="6">
                                        <v-text-field color="purple" class="mt-0"
                                                      :type="registerPassVisible ? 'text' : 'password'"
                                                      v-model="registerFields.password" label="Contraseña"
                                                      :rules="registerRules.password" validate-on-blur
                                                      hint="Mínimo 8 caracteres" required>
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols=12 md="6">
                                        <v-text-field color="purple" class="mt-0"
                                                      :type="registerPassVisible ? 'text' : 'password'"
                                                      v-model="registerFields.password_confirmation"
                                                      label="Confirmar contraseña"
                                                      :rules="registerRules.password_confirmation"
                                                      :error-messages="password_confirmation" required
                                                      :append-icon="registerPassVisible ? 'mdi-eye' : 'mdi-eye-off'"
                                                      @click:append="registerPassVisible = !registerPassVisible"
                                        >
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters class="justify-space-between">
                                    <v-col cols="12" md="3">
                                        <v-btn @click="registerDialog = false" class="error mt-3" block>Cancelar</v-btn>
                                    </v-col>
                                    <v-col cols="12" md="3">
                                        <v-btn @click="register" class="purple float-right mt-3" dark block :loading="registerLoading">
                                            Registrarse
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-dialog>

                <v-dialog v-model="loginDialog" max-width="400" keydown overlay-opacity=".9">
                    <template v-slot:activator="{ on }">
                        <v-btn class="mx-2" v-on="on">Ingresar</v-btn>
                    </template>
                    <v-card :loading="loginLoading">
                        <v-card-title class="white--text purple">
                            Ingreso
                            <v-spacer></v-spacer>
                            <v-btn dark @click="loginDialog = false" icon>
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-card-title>
                        <v-card-text>
                            <p class="mt-3 mb-0 text-center font-weight-bold">Ingresa con</p>
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-btn block height="48" class="pa-1 white--text" color="#f80019" rounded>
                                        <v-avatar class="float-left" color="pa-2 white" size="40">
                                            <v-img src="./assets/google.png" contain></v-img>
                                        </v-avatar>
                                        <v-spacer></v-spacer>
                                        Google
                                        <v-spacer></v-spacer>
                                    </v-btn>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-btn block height="48" class="pa-1 white--text" color="#464498" rounded @click="facebookLogin">
                                        <v-avatar class="float-left" color="pa-2 white" size="40">
                                            <v-img src="./assets/facebook.png" contain></v-img>
                                        </v-avatar>
                                        <v-spacer></v-spacer>
                                        Facebook
                                        <v-spacer></v-spacer>
                                    </v-btn>
                                </v-col>
                            </v-row>
                            <p class="mt-5 mb-0 text-center font-weight-bold">Tu cuenta</p>
                            <v-form v-model="validLogin" ref="loginForm" class="pt-1">
                                <v-text-field color="purple" v-model="loginFields.email"
                                              :rules="loginNameRules" class="mt-0"
                                              label="Correo electrónico" required
                                              :error-messages="loginError"></v-text-field>
                                <v-text-field color="purple" class="mt-0"
                                              v-model="loginFields.password"
                                              :append-icon="loginPassVisible ? 'mdi-eye' : 'mdi-eye-off'"
                                              :rules="loginPassRules"
                                              :type="loginPassVisible ? 'text' : 'password'"
                                              label="Contraseña"
                                              @click:append="loginPassVisible = !loginPassVisible"
                                              icon></v-text-field>
                                <v-checkbox color="purple"
                                            v-model="loginFields.remember" type="checkbox"
                                            class="mx-auto mt-2"
                                            label="Recuérdame"></v-checkbox>
                                <v-row no-gutters class="justify-space-between">
                                    <v-col cols="12" md="3">
                                        <v-btn @click="loginDialog = false" block class="error mt-2">Cancelar</v-btn>
                                    </v-col>
                                    <v-col cols="12" md="3">
                                        <v-btn @click="login" block class="float-right purple mt-2" dark :loading="loginLoading">
                                            Ingresar
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-dialog>

            </template>
        </v-app-bar>

        <v-main>
            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>
    import {mapActions, mapState} from 'vuex'

    export default {
        name: 'App',

        data: () => ({
            themeLoading: false,
            themeIcon: null,
            dark: null,

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
        }),

        created() {
            axios.get('https://ctools.mixture.com.co/sanctum/csrf-cookie')

            this.themeIcon = this.getIcon()

            this.getUser()
        },

        computed: {
            ...mapState(['user']),

            password_confirmation() {
                if (this.registerFields.password_confirmation !== this.registerFields.password &&
                    this.registerFields.password_confirmation !== undefined)
                    return 'No coincide'

                return null
            },
            homeActive() {
                return this.$route.path === '/'
            }
        },

        watch: {
            async dark() {
                this.themeIcon = 'mdi-brightness-4'
                this.themeLoading = true
                await new Promise(r => setTimeout(r, 100))
                this.themeIcon = this.getIcon()
                this.$root.$vuetify.theme.dark = this.dark
                await new Promise(r => setTimeout(r, 1000))
                this.themeLoading = false
            }
        },

        methods: {
            ...mapActions(['logout']),

            getIcon() {
                return this.dark ? 'mdi-brightness-7' : 'mdi-brightness-5';
            },

            getUser() {
                axios.get('https://ctools.mixture.com.co/api/user')
                    .then(({data}) => this.$store.commit('setUser', data))
                    .catch(error => this.$store.commit('setUser', null))
            },

            register() {
                if (this.$refs.registerForm.validate()) {
                    this.registerLoading = true
                    this.registerEmailError = null
                    axios.post('https://ctools.mixture.com.co/api/register', this.registerFields)
                        .then(response => {
                            this.getUser()
                            this.$refs.registerForm.reset()
                            this.registerDialog = false
                        })
                        .catch(error => {
                            this.registerFields.password = this.registerFields.password_confirmation = null
                            this.$refs.registerForm.resetValidation()
                            this.registerEmailError = error.response.data.errors.email
                        })
                        .finally(() => this.registerLoading = false)
                }
            },

            login() {
                if (this.$refs.loginForm.validate()) {
                    this.loginLoading = true
                    this.loginError = null
                    axios.post('https://ctools.mixture.com.co/api/login', this.loginFields)
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

            facebookLogin() {
                this.loginLoading = this.registerLoading = true

                FB.login(response => {
                    if (response.authResponse) {
                        axios.get('https://ctools.mixture.com.co/api/login/facebook')
                            .then(() => this.getUser())
                            .finally(() => this.loginDialog = this.registerDialog = this.loginLoading = this.registerLoading = false)
                    } else
                        this.loginDialog = this.loginLoading = this.registerLoading = this.registerLoading = false
                }, {scope: 'email'})

            }
        }

    };
</script>
