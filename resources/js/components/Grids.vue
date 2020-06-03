<template>
    <div class="fill-height">

        <div class="fill-height d-flex flex-column justify-center" v-if="!this.$root.user">
            <p class="text-center">
                <v-icon size="200">mdi-google-controller-off</v-icon><br>
                <span class="text--secondary font-weight-black">No disponible</span>
            </p>
            <v-alert icon="mdi-exclamation-thick" prominent border="right"
                     class="mx-auto pr-10" max-width="750px"
                     colored-border color="red" elevation="4">
                Debes ingresar para poder utilizar <b>CGrid</b>
            </v-alert>
        </div>

        <template v-else>
            <v-row>
                <v-col sm="8">
                    <p class="display-2">
                        Mis planes
                    </p>

                </v-col>
                <v-col>
                    <v-card shaped>
                        <v-card-title v-if="this.$root.user">
                            {{ this.$root.user.name }}
                        </v-card-title>
                    </v-card>
                </v-col>
            </v-row>
        </template>

    </div>
</template>
<script>
    export default {
        data() {
            return {}
        },
        created() {
        }
    }
</script>
