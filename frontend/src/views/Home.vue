<template>
    <v-row class="flex-column">
        <v-col>
            <v-stepper class="mx-auto" v-model="stepper.step" style="max-width: 600px" alt-labels>
                <v-stepper-header>
                    <v-img src="@/assets/stepper_header.png"></v-img>
                </v-stepper-header>
                <v-stepper-header class="elevation-0 grey lighten-3">
                    <template v-for="(step, index) in stepper.steps">
                        <v-stepper-step :step="index + 1" :color="stepper.step > index + 1 ? 'green' : 'purple'"
                                        :complete="stepper.step > index + 1" class="px-0">
                            {{ step.header }}
                        </v-stepper-step>
                        <v-divider v-if="index + 1 < stepper.steps.length"></v-divider>
                    </template>
                </v-stepper-header>
                <v-stepper-items class="pa-6">
                    <v-row no-gutters>
                        <v-btn dark color="purple" v-if="stepper.step - 1" @click.prevent="stepper.step--">Anterior</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn dark color="purple" @click="next(stepper.step - 1)">Siguiente</v-btn>
                    </v-row>
                    <v-stepper-content v-for="(step, index) in stepper.steps" :step="index + 1" class="pa-0 pt-4">
                        <v-form ref="form" v-model="step.valid">
                            <v-select v-for="field in step.fields" :label="field.field" placeholder="..."
                                      :items="field.options.map(option => option.text)" dense class="mt-4"
                                      :multiple="field.type === 'checklist'" chips deletable-chips
                                      :rules="[v => (!!v || field.type === 'checklist') || 'Requerido']">
                            </v-select>
                        </v-form>
                    </v-stepper-content>
                </v-stepper-items>
            </v-stepper>
        </v-col>
    </v-row>
</template>
<script>
    export default {
        methods: {
            next (index) {
                if (this.$refs.form[index].validate())
                    this.stepper.step++
            }
        },

        data: () => ({
            stepper: {
                step: 1,
                steps: [
                    {
                        header: 'Atracción',
                        valid: true,
                        fields: [
                            {
                                field: '¿Qué utilidad le das a tus redes sociales?', value: 0,
                                type: 'checklist',
                                options: [
                                    {text: 'Medio de ventas', value: 5},
                                    {text: 'Medio de comunicación', value: 10},
                                    {text: 'Medio para crear comunidad digital', value: 15},
                                ]
                            },
                            {
                                field: '¿Tus inversiones en publicidad digital son?', value: 0,
                                type: 'radio',
                                options: [
                                    {text: 'De 10 usd a 399 usd', value: 10},
                                    {text: 'De 400 usd a 600 usd', value: 30},
                                    {text: 'Más de 600 usd', value: 40},
                                    {text: 'No realizo publicidad digital', value: 0},
                                ]
                            },
                            {
                                field: '¿Realizas actividades de posicionamiento web (seo)?', value: 0,
                                type: 'radio',
                                options: [
                                    {text: 'Si contrato el servicio con una agencia', value: 30},
                                    {text: 'Si tengo proceso interno', value: 30},
                                    {text: 'No hago seo', value: 0},
                                ]
                            },
                        ]
                    },
                    {
                        header: 'Conversión',
                        valid: true,
                        fields: [
                            {
                                field: '¿Utilizas landing pages?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 20},
                                    {text: 'No', value: 0},
                                    {text: 'No sé', value: 0},
                                ]
                            },
                            {
                                field: '¿Usas formularios de captación de datos?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 20},
                                    {text: 'No', value: 0},
                                ]
                            },
                            {
                                field: '¿Sabes cual es el rendimiento de tus landing pages?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 20},
                                    {text: 'No', value: 0},
                                    {text: 'No uso landing pages', value: 0},
                                ]
                            },
                            {
                                field: '¿Haces segmentación de tus bases de datos?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 20},
                                    {text: 'No', value: 0},
                                ]
                            },
                        ]
                    },
                    {
                        header: 'Relación',
                        valid: true,
                        fields: [
                            {
                                field: '¿Haces email marketing con tus bases de datos?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 16},
                                    {text: 'No', value: 0},
                                ]
                            },
                            {
                                field: '¿Haces un seguimiento de la interacción de los envíos de email?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 16},
                                    {text: 'No', value: 0},
                                    {text: 'No hago email marketing', value: 0},
                                ]
                            },
                            {
                                field: '¿Cuantas interacciones de relacionamiento tienes con tus prospectos  (emails, mensajes de texto, etc)?',
                                type: 'radio',
                                options: [
                                    {text: 'Una única vez', value: 4},
                                    {text: 'Una vez por mes', value: 8},
                                    {text: 'De 2 a 4 veces por mes', value: 12},
                                    {text: 'Más de 5 veces por meses', value: 16},
                                ]
                            },
                            {
                                field: '¿Tienes algun criterio de calificación para tus clientes potenciales (puntaje de lead)?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 16},
                                    {text: 'No', value: 0},
                                ]
                            },
                            {
                                field: '¿El proceso de relacionamiento con tus bases de datos, lo haces:?',
                                type: 'radio',
                                options: [
                                    {text: 'MANUAL', value: 8},
                                    {text: 'AUTOMATIZADO', value: 16},
                                    {text: 'NO HAGO', value: 0},
                                ]
                            },
                        ]
                    },
                    {
                        header: 'Ventas',
                        valid: true,
                        fields: [
                            {
                                field: '¿Tienes un equipo de ventas estructurado?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 16},
                                    {text: 'No', value: 0},
                                ]
                            },
                            {
                                field: '¿Cuántas interacción comercial tienes con un prospecto antes de la venta?',
                                type: 'radio',
                                options: [
                                    {text: '1', value: 5},
                                    {text: '2 a 4', value: 10},
                                    {text: 'Más de 5', value: 16},
                                    {text: 'No se', value: 0},

                                ]
                            },
                            {
                                field: '¿Utilizas CRM para administrar tus prospectos?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 16},
                                    {text: 'No', value: 0},
                                    {text: 'No se qué es un CRM', value: 0},
                                ]
                            },
                            {
                                field: '¿Conoce el paso a paso de un cliente potencial para que compre tu producto - servicio (de principio al fin)?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 16},
                                    {text: 'No', value: 0},
                                    {text: 'No sé', value: 0},
                                ]
                            },
                            {
                                field: '¿Qué haces con los prospectos que no compran el producto o servicio?',
                                type: 'radio',
                                options: [
                                    {text: 'Se descarta el contacto', value: 0},
                                    {text: 'Se guarda para otro momento', value: 8},
                                    {text: 'Lo ingresas nuevamente al embudo de ventas', value: 16},
                                ]
                            },
                        ]
                    },
                    {
                        header: 'Análisis',
                        valid: true,
                        fields: [
                            {
                                field: '¿Sabes cual es la cantidad de tráfico que pasa por tu sitio web mensualmente?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 20},
                                    {text: 'No', value: 0},
                                ]
                            },
                            {
                                field: '¿Realizas seguimiento de las campañas digitales detalladamente?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 20},
                                    {text: 'No', value: 0},
                                ]
                            },
                            {
                                field: '¿Conoces el costo de adquisición por cada cliente conseguido?',
                                type: 'radio',
                                options: [
                                    {text: 'Sí', value: 20},
                                    {text: 'No', value: 0},
                                ]
                            },
                            {
                                field: '¿Realizas auditorías para hacer ciclos de mejora conitua de estrategia de marketing digital?',
                                type: 'radio',
                                options: [
                                    {text: 'Si 2 veces al año', value: 4},
                                    {text: 'Si cada 3 meses', value: 8},
                                    {text: 'Si cada 2 meses', value: 12},
                                    {text: 'Si mensualmente', value: 16},
                                    {text: 'No hago', value: 0},

                                ]
                            },
                        ]
                    },
                ]
            }
        }),
    }
</script>
<style>
    .v-stepper__wrapper {
        overflow: visible !important;
    }
</style>
