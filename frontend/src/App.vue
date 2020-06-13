<template>
    <v-app>
        <v-app-bar app dense color="purple" dark clipped-left>
            <v-toolbar-title class="mx-2">Mixture | CTools</v-toolbar-title>
            <v-toolbar-items>
                <v-btn text to="/">Inicio</v-btn>
                <v-btn text to="/grids">CGrid</v-btn>
            </v-toolbar-items>
            <v-spacer></v-spacer>

            <template v-if="this.$store.state.user">
                <v-avatar :color="this.$store.state.user.profile_image" size="35">
                    {{ this.$store.getters.nameInitials }}
                </v-avatar>
                <v-btn class="mx-2" @click="logout">Salir</v-btn>
            </template>
            <template v-else>
                <v-dialog v-model="registerDialog" max-width="500" keydown overlay-opacity=".9">
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on" text>Registrarse</v-btn>
                    </template>
                    <v-card :loading="registerLoading" class="pa-1">
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
                                        <v-btn @click="register" class="purple float-right mt-3" dark block>
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
                    <v-card :loading="loginLoading" class="pa-1">
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
                                        <v-btn @click="login" block class="float-right purple mt-2" dark>Ingresar
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-dialog>

            </template>
        </v-app-bar>

        <v-content>
            <router-view></router-view>
        </v-content>
    </v-app>
</template>

<script>
    import HelloWorld from './components/HelloWorld';

    export default {
        name: 'App',

        components: {
            HelloWorld,
        },

        data: () => ({
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

            this.getUser()
        },

        computed: {
            password_confirmation() {
                if (this.registerFields.password_confirmation != this.registerFields.password &&
                    this.registerFields.password_confirmation !== undefined)
                    return 'No coincide'

                return null
            },
        },

        methods: {
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

            logout() {
                axios.post('https://ctools.mixture.com.co/api/logout').then(response => this.$store.commit('setUser', null))
            },

            facebookLogin () {
                FB.login(function(response){
                    if (response.authResponse) {
                        console.log('Welcome!  Fetching your information.... ');
                        FB.api('/me?fields=first_name,last_name,middle_name,email', response => {console.log(response)});
                    } else {
                        console.log('User cancelled login or did not fully authorize.');
                    }
                }, {scopes: 'email', return_scopes: true});
            }
        }

    };
</script>
