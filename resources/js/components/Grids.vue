<template>
    <div>
        <div v-if="this.$root.user">
            <v-navigation-drawer app clipped permanent dark src="/assets/purple.png">
                <v-list dense nav class="py-0" style="background: rgba(0, 0, 0, .3)">
                    <v-list-item two-line class="px-0">
                        <v-list-item-avatar class="white--text" :color="this.$root.avatarColor">
                            {{ this.$root.userInitials }}
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title class="body-1">{{ this.$root.user.name }}</v-list-item-title>
                            <v-list-item-subtitle>{{ this.$root.user.last_name }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <v-divider></v-divider>

                <v-list dense nav>
                    <v-list-group value="true" prepend-icon="mdi-calendar-blank-multiple">
                        <template v-slot:activator>
                            <v-list-item-title>Planes</v-list-item-title>
                        </template>

                        <v-list-group no-action sub-group>
                            <template v-slot:activator>
                                <v-list-item-title>Mis planes</v-list-item-title>
                                <span class="caption">2</span>
                                <v-list-item-icon><v-icon>mdi-account-cowboy-hat</v-icon></v-list-item-icon>
                            </template>

                            <v-list-item>
                                <v-list-item-title>Home</v-list-item-title>
                                <v-list-item-icon><v-icon>mdi-home</v-icon></v-list-item-icon>
                            </v-list-item>
                        </v-list-group>

                        <v-list-group no-action sub-group>
                            <template v-slot:activator>
                                <v-list-item-title>Compartidos<br>conmigo</v-list-item-title>
                                <span class="caption">2</span>
                                <v-list-item-icon><v-icon>mdi-account-group-outline</v-icon></v-list-item-icon>
                            </template>

                            <v-list-item>
                                <v-list-item-title>Home</v-list-item-title>
                                <v-list-item-icon><v-icon>mdi-home</v-icon></v-list-item-icon>
                            </v-list-item>
                        </v-list-group>
                    </v-list-group>
                </v-list>

                <v-list dense nav style="position:absolute;bottom:0;width:100%;">
                    <v-list-group prepend-icon="mdi-cog" style="background:rgba(255,255,255,.1)" class="pb-1">
                        <template v-slot:activator>
                            <v-list-item-title>Preferencias</v-list-item-title>
                        </template>
                        <v-list-item>
                            <v-list-item-title>Home</v-list-item-title>
                            <v-icon>mdi-home</v-icon>
                        </v-list-item>
                        <v-list-item link @click="dark = !dark" class="ma-2 mb-1">
                            <v-list-item-icon>
                                <v-icon>{{ themeIcon }}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>
                                <v-switch v-model="dark" height="0" dense :loading="themeLoading" readonly></v-switch>
                            </v-list-item-title>
                        </v-list-item>
                    </v-list-group>
                </v-list>
            </v-navigation-drawer>

            <div class="blue">
                <p class="display-4">
                    Mis planes
                </p>
                <p class="display-4">
                    Compartidos conmigo
                </p>
            </div>
        </div>

        <div class="fill-height d-flex flex-column justify-center" v-else>
            <p class="text-center">
                <v-icon size="200">mdi-google-controller-off</v-icon>
                <br>
                <span class="text--secondary font-weight-black">No disponible</span>
            </p>
            <v-alert icon="mdi-exclamation-thick" prominent border="right"
                     class="mx-auto pr-10" max-width="750px"
                     colored-border color="red" elevation="4">
                Debes ingresar para poder utilizar <b>CGrid</b>
            </v-alert>
        </div>


    </div>
</template>
<script>
    export default {
        data() {
            return {
                dark: this.$root.$vuetify.theme.dark,
                themeLoading: false,
                themeIcon: null,
            }
        },
        created() {
           this.themeIcon = this.getIcon()
        },
        methods: {
            getIcon() {
                return this.dark ? 'mdi-brightness-7' : 'mdi-brightness-5';
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
        }
    }
</script>
