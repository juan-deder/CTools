<template>
    <div class="grids fill-height">

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
