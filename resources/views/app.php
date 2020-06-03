<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CGrid</title>

    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
</head>
<style>
    html {
        overflow: auto !important;
    }

    .v-btn {
        text-transform:none !important;
        letter-spacing: 0 !important;
    }

    .v-toolbar__content {
        padding:0 !important;
    }

    .v-label {
        font-size: 14px !important;
    }
</style>
<body>
<div id="app">
    <v-app>
        <v-app-bar app dense color="purple" dark>
            <v-toolbar-title class="mx-2">Mixture</v-toolbar-title>
            <v-toolbar-items>
                <v-btn text to="/">Inicio</v-btn>
                <v-btn text to="/grids">CGrid</v-btn>
            </v-toolbar-items>
            <v-spacer></v-spacer>

            <template v-if="user">
                <v-avatar :color="avatarColor" size="35">
                    {{ userInitials }}
                </v-avatar>
                <v-btn class="mx-2"  @click="logout">Salir</v-btn>
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
                                        <v-avatar class="float-left" style="position:absolute;left:0" color="pa-2 white" size="40">
                                            <v-img src="/assets/google.png" contain></v-img>
                                        </v-avatar>
                                        Google
                                    </v-btn>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-btn block height="48" class="pa-1 white--text" color="#464498" rounded>
                                        <v-avatar class="float-left" style="position:absolute;left:0" color="pa-2 white" size="40">
                                            <v-img src="/assets/facebook.png" contain></v-img>
                                        </v-avatar>
                                        Facebook
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
                                        <v-btn @click="register" class="purple float-right mt-3" dark block>Registrarse</v-btn>
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
                                        <v-avatar class="float-left" style="position:absolute;left:0" color="pa-2 white" size="40">
                                            <v-img src="/assets/google.png" contain></v-img>
                                        </v-avatar>
                                        Google
                                    </v-btn>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-btn block height="48" class="pa-1 white--text" color="#464498" rounded>
                                        <v-avatar class="float-left" style="position:absolute;left:0" color="pa-2 white" size="40">
                                            <v-img src="/assets/facebook.png" contain></v-img>
                                        </v-avatar>
                                        Facebook
                                    </v-btn>
                                </v-col>
                            </v-row>
                            <p class="mt-5 mb-0 text-center font-weight-bold">Tu cuenta</p>
                            <v-form v-model="validLogin" ref="loginForm" class="pt-1">
                                <v-text-field color="purple" v-model="loginFields.email"
                                              :rules="loginNameRules"
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
                                <v-btn @click="loginDialog = false" class="error mt-2">Cancelar</v-btn>
                                <v-btn @click="login" class="float-right purple mt-2" dark>Ingresar</v-btn>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-dialog>

            </template>
        </v-app-bar>

        <v-content>
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-content>
    </v-app>
</div>
<script src="../js/app.js"></script>
</body>
</html>
