<template>
    <div class="fill-height">
        <div class="fill-height" v-if="user">
            <div class="fill-height d-flex flex-column pa-9">
                <v-card outlined class="tertiary mb-9" :style="{borderColor: secondary + ' !important'}">
                    <v-card-title class="py-0">
                        <v-img height="70" width="70" class="rounded mt-n4 elevation-5 shrink" src="@/assets/purple.png">
                            <v-row class="fill-height ma-0" align="center" justify="center">
                                <v-icon dark>mdi-calendar-blank-multiple</v-icon>
                            </v-row>
                        </v-img>
                        <span class="ml-2 font-weight-light">Mis planes</span>
                        <v-spacer></v-spacer>
                        <v-dialog v-model="dialog" max-width="500px" dark>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn large color="purple" icon v-bind="attrs" v-on="on">
                                    <v-avatar size="30">
                                        <v-img src="@/assets/plus.png" contain></v-img>
                                    </v-avatar>
                                </v-btn>
                            </template>
                            <v-card style="background:#663399 !important">
                                <v-card-title>
                                    <v-img height="70" width="70" class="rounded elevation-5 shrink mt-n6"
                                           src="@/assets/purple.png"
                                           style="position:fixed">
                                        <v-row class="fill-height ma-0" align="center" justify="center">
                                            <v-icon dark>mdi-calendar-blank-multiple</v-icon>
                                        </v-row>
                                    </v-img>
                                    <div class="text-center py-1 font-weight-light grow font-weight-medium">
                                        {{ formTitle }}
                                    </div>
                                </v-card-title>
                                <v-card-text>
                                    <v-form :disabled="viewing">
                                        <v-row no-gutters :justify-md="'space-between'">
                                            <v-col cols="12" md="5">
                                                <v-text-field v-model="editedItem.name" label="Nombre"></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="5">
                                                <v-checkbox v-model="editedItem.active" :label="editedItem.active ? 'Activa' : 'Inactiva'">
                                                </v-checkbox>
                                            </v-col>
                                        </v-row>
                                        <v-divider class="my-4"></v-divider>
                                        <v-autocomplete v-model="editedItem.committerIds"
                                                        :items="committers"
                                                        chips hide-selected hide-no-data
                                                        label="Colaboradores"
                                                        item-text="name"
                                                        item-value="id"
                                                        multiple>
                                            <template v-slot:selection="data">
                                                <v-row no-gutters>
                                                    <v-col cols="6">
                                                        <v-chip cols="6" v-bind="data.attrs"
                                                                :input-value="data.selected" close light
                                                                @click="data.select"
                                                                @click:close="removeCommitter(data.item)">
                                                            <avatar :user="data.item" :props="{left: true}"></avatar>
                                                            {{ data.item.name }}
                                                        </v-chip>
                                                    </v-col>
                                                    <v-col cols="6">
                                                        <v-select cols="6" v-model="editedCommitters[data.item.id]"
                                                                  :items="roles"
                                                                  outlined @click.stop class="roles"
                                                                  dense multiple label="Roles">
                                                            <template v-slot:selection="{ item, index }">
                                                                <span v-if="index === 0">{{ item }}</span>
                                                                <span
                                                                    v-if="index === 1"
                                                                    class="ml-1 grey&#45;&#45;text caption"
                                                                >(y {{ editedCommitters[data.item.id].length - 1 }} más)</span>
                                                            </template>
                                                        </v-select>
                                                    </v-col>

                                                </v-row>
                                            </template>

                                        </v-autocomplete>
                                    </v-form>
                                </v-card-text>
                                <v-card-actions class="pa-6 pt-0">
                                    <v-btn large class="error darken-1" dark @click="close">Cancelar</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn large class="purple darken-1" dark @click="save" :disabled="viewing">Guardar</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-card-title>
                    <v-card-text>
                        <v-data-table :headers="headers" :items="owned" multi-sort fixed-header item-key="id"
                                      sort-by="created_at" sort-desc>
                            <template v-slot:item.created_at="{item}">
                                <span class="font-weight-light text-capitalize">{{ moment(item.created_at).fromNow() }}</span>
                            </template>
                            <template v-slot:item.name="{item}">
                                <v-btn :to="'Posts/' + item.id" text small color="purple darken-3" :disabled="!item.active">
                                    {{ item.name }}<v-icon right>mdi-link-variant</v-icon>
                                </v-btn>
                            </template>
                            <template v-slot:item.active="{item}">
                                <v-simple-checkbox disabled v-model="item.active"></v-simple-checkbox>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-btn icon>
                                    <v-icon color="amber" @click="editItem(item)">mdi-calendar-edit</v-icon>
                                </v-btn>
                                <v-btn icon>
                                    <v-icon color="red" @click="deleteItem(item)">mdi-calendar-remove</v-icon>
                                </v-btn>
                            </template>
                            <template v-slot:no-data>
                                <div>
                                    <v-btn rounded text class="pa-2" color="none" large @click="dialog = !dialog">
                                        Crear mi primer plan
                                        <v-avatar size="30" color="prominent" class="ml-2 pa-1">
                                            <v-icon color="purple darken-3">mdi-calendar-plus</v-icon>
                                        </v-avatar>
                                    </v-btn>
                                </div>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
                <v-card outlined class="tertiary" :style="{borderColor: secondary + ' !important'}">
                    <v-card-title class="py-0">
                        <v-img height="70" width="70" class="rounded mt-n4 elevation-5 shrink" src="@/assets/navy.png">
                            <v-row class="fill-height ma-0" align="center" justify="center">
                                <v-icon dark>mdi-account-multiple-outline</v-icon>
                            </v-row>
                        </v-img>
                        <span class="ml-2 font-weight-light">Compartidos conmigo</span>
                    </v-card-title>
                    <v-card-text>
                        <v-data-table :headers="headers" :items="shared" multi-sort fixed-header item-key="id"
                                      sort-by="created_at" sort-desc>
                            <template v-slot:item.created_at="{item}">
                                <span class="font-weight-light text-capitalize">{{ moment(item.created_at).fromNow() }}</span>
                            </template>
                            <template v-slot:item.name="{item}">
                                <v-btn :to="'Posts/' + item.id" text small color="purple darken-3" :disabled="!item.active">
                                    {{ item.name }}<v-icon right>mdi-link-variant</v-icon>
                                </v-btn>
                            </template>
                            <template v-slot:item.active="{item}">
                                <v-simple-checkbox disabled v-model="item.active"></v-simple-checkbox>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-btn icon>
                                    <v-icon color="indigo" @click="editItem(item, true)">mdi-eye</v-icon>
                                </v-btn>
                            </template>
                            <template v-slot:no-data>
                                <div>
                                    <v-btn rounded text class="pa-2" color="none" large @click="dialog = !dialog">
                                        Crear mi primer plan
                                        <v-avatar size="30" color="prominent" class="ml-2 pa-1">
                                            <v-img src="@/assets/plus.png" contain></v-img>
                                        </v-avatar>
                                    </v-btn>
                                </div>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </div>
        </div>

        <div class="d-flex flex-column justify-center" v-else>
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
            <v-card flat max-width="800px" class="mx-auto text-center">
                <v-card-title>
                    CGrid
                </v-card-title>
                <v-card-subtitle>
                    Content Grid
                </v-card-subtitle>
                <v-card-text>
                    CGrid es una parrilla de contenidos, herramienta de diseño enfocada en asistir al proceso de
                    planificación y despliegue de contenido audio-visual dirigido a redes sociales y otras
                    plataformas virtuales.
                </v-card-text>
            </v-card>
        </div>

    </div>
</template>
<script>
    import {mapState} from 'vuex'

    export default {
        data: () => ({
            dialog: false,
            viewing: false,

            headers: [
                {text: 'Creación', value: 'created_at', filterable: false, align: 'center'},
                {text: 'Nombre', value: 'name', align: 'center'},
                {text: 'Miembros', value: 'count', filterable: false, align: 'center'},
                {text: 'Activa', value: 'active', filterable: false, align: 'center'},
                {text: 'Acciones', value: 'actions', sortable: false, filterable: false, align: 'center'},
            ],

            owned: [],
            shared: [],

            editedIndex: -1,
            editedItem: {
                created_at: '',
                name: '',
                count: '',
                active: false,
                committerIds: [], // Autocomplete this.committers[n].id
            },
            editedCommitters: {}, // {id:  ['Dueño', 'Editor', 'Aprobador', 'Observador']}

            defaultItem: {
                created_at: '',
                name: '',
                count: '',
                active: false,
                committerIds: []
            },

            committers: [], // Autocomplete data source. Takes name and id

            roles: ['Dueño', 'Editor', 'Aprobador', 'Observador']
        }),

        computed: {
            ...mapState(['user']),

            formTitle() {
                return this.editedIndex === -1 ? 'Crear plan' : 'Editar plan'
            },
            secondary() {
                return this.$vuetify.theme.dark ? this.$vuetify.theme.themes.dark.secondary : this.$vuetify.theme.themes.light.secondary
            },
        },

        watch: {
            dialog(val) {
                val || this.close()
            },

            // Pushes a new element to this.editedCommitters with key and name as id and [] respectively, e.g, {1: []}
            // This element will be used by roles <v-select> to store the roles array in te respective committer id key
            editedItem: {
                handler: function (val) {
                    for (let id of (val.committerIds ? val.committerIds : []))
                        this.editedCommitters[id] = this.editedCommitters[id] ? this.editedCommitters[id] : []
                },
                deep: true
            }
        },

        created() {
            axios.get('https://ctools.mixture.com.co/api/grids').then(({data}) => {
                for (let grid of data) {
                    if (grid.committers.find(user => user.id === this.user.id).roles.indexOf('owner') >= 0)
                        this.owned.push(grid)
                    else
                        this.shared.push(grid)
                }
            })

            axios.get('https://ctools.mixture.com.co/api/users/committers')
                .then(({data}) => this.committers = data.filter(committer => committer.id !== this.user.id))
        },

        methods: {
            save() {
                let roles = {}
                const translations = {Aprobador: 'approver', Editor: 'editor', Observador: 'observer', Dueño: 'owner'}
                for (let id in this.editedCommitters)
                    roles[id] = {roles: this.editedCommitters[id].map(role => translations[role]).join(',')}

                let index = this.editedIndex
                if (index > -1) {
                    axios.put('https://ctools.mixture.com.co/api/grids/' + this.owned[index].id, {
                        name: this.editedItem.name,
                        active: this.editedItem.active,
                        committers: roles
                    }).then(({data}) => {
                        Object.assign(this.owned[index], data)
                    })
                } else {
                    axios.post('https://ctools.mixture.com.co/api/grids', {
                        name: this.editedItem.name,
                        active: this.editedItem.active,
                        committers: roles
                    }).then(({data}) => this.owned.push(data))
                }
                this.close()
            },

            editItem(item, viewing = false) {
                this.viewing = viewing

                let grid = viewing ? this.shared : this.owned

                this.editedIndex = grid.indexOf(item)
                this.editedItem = Object.assign({}, item)

                const translations = {approver: 'Aprobador', editor: 'Editor', observer: 'Observador', owner: 'Dueño'}
                this.editedItem.committerIds = []
                for (let user of grid[this.editedIndex].committers) {
                    this.editedCommitters[user.id] = user.roles.split(',').map(role => translations[role])
                    this.editedItem.committerIds.push(user.id)
                }

                this.dialog = true
            },

            deleteItem(item) {
                const index = this.owned.indexOf(item)
                axios.delete('https://ctools.mixture.com.co/api/grids/' + item.id)
                    .then(response => this.owned.splice(index, 1))
            },

            close() {
                this.viewing = this.dialog = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedCommitters = Object.assign({})
                    this.editedIndex = -1
                })
            },

            removeCommitter(item) {
                delete this.editedCommitters[item.id]
                this.editedItem.committerIds.splice(this.editedItem.committerIds.indexOf(item.id), 1)
            },
        },
    }
</script>
<style>
    .roles input {
        min-width: 0 !important;
    }
</style>
