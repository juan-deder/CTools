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
                {{ user.name }}
                <v-btn class="mx-2"  @click="logout">Salir</v-btn>
            </template>
            <template v-else>
                <v-dialog v-model="registerDialog" max-width="600" keydown>
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on" text>Registrarse</v-btn>
                    </template>
                    <v-card :loading="registerLoading" class="pa-1">
                        <v-card-title class="white--text purple">
                            Registro
                            <v-spacer></v-spacer>
                            <v-btn dark @click="registerDialog = false" icon="mdi-close">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-card-title>
                        <v-card-text>
                            <v-form ref="registerForm" :value="validRegister" class="pt-3">
                                <v-row>
                                    <v-col cols="12" sm="6" class="py-0">
                                        <v-text-field color="purple" v-model="registerFields.name"
                                                      label="Nombres"
                                                      :rules="registerRules.name" required></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" class="py-0">
                                        <v-text-field color="purple" v-model="registerFields.last_name"
                                                      label="Apellidos"
                                                      :rules="registerRules.last_name" required></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-text-field color="purple" type="email" v-model="registerFields.email"
                                              label="Correo electrónico"
                                              :rules="registerRules.email" :error-messages="registerEmailError"
                                              validate-on-blur required></v-text-field>
                                <v-row>
                                    <v-col cols="12" sm="6" class="py-0">
                                        <v-text-field color="purple"
                                                      :type="registerPassVisible ? 'text' : 'password'"
                                                      v-model="registerFields.password" label="Contraseña"
                                                      :rules="registerRules.password" validate-on-blur
                                                      hint="Mínimo 8 caracteres" counter="0" required
                                                      :append-icon="registerPassVisible ? 'mdi-eye' : 'mdi-eye-off'"
                                                      @click:append="registerPassVisible = !registerPassVisible"
                                        >
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" class="py-0">
                                        <v-text-field color="purple"
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
                                <v-btn @click="registerDialog = false" class="error mt-4">Cancelar</v-btn>
                                <v-btn @click="register" class="purple float-right mt-4" dark>Registrarse
                                </v-btn>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-dialog>

                <v-dialog v-model="loginDialog" max-width="400" keydown>
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
                            <v-form v-model="validLogin" ref="loginForm" class="pt-3">
                                <v-text-field color="purple" v-model="loginFields.email"
                                              :rules="loginNameRules"
                                              label="Correo electrónico" required
                                              :error-messages="loginError"></v-text-field>
                                <v-text-field color="purple"
                                              v-model="loginFields.password"
                                              :append-icon="loginPassVisible ? 'mdi-eye' : 'mdi-eye-off'"
                                              :rules="loginPassRules"
                                              :type="loginPassVisible ? 'text' : 'password'"
                                              label="Contraseña"
                                              @click:append="loginPassVisible = !loginPassVisible"
                                              icon></v-text-field>
                                <v-btn @click="loginDialog = false" class="error mt-4">Cancelar</v-btn>
                                <v-btn @click="login" class="float-right purple mt-4" dark>Ingresar</v-btn>
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
</div>
<script src="../js/app.js"></script>
</body>
</html>
