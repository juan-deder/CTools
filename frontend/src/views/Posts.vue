<template>
    <v-card outlined class="tertiary ma-9" style="border-color:darkgray !important;">
        <v-card-title class="py-0">
            <v-img height="70" width="70" class="mt-n4 rounded elevation-5 shrink" src="@/assets/purple.png">
                <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-icon dark>mdi-calendar</v-icon>
                </v-row>
            </v-img>
            <div class="ml-2 font-weight-light">
                Grid<br>
                <div class="subtitle-2">2020-03-23</div>
            </div>
            <v-spacer></v-spacer>
            <v-dialog v-model="postDialog" max-width="500px">
                <template v-slot:activator="{on, attrs}">
                    <v-btn large color="purple" icon v-bind="attrs" v-on="on">
                        <v-avatar size="30">
                            <v-img src="@/assets/plus.png" contain></v-img>
                        </v-avatar>
                    </v-btn>
                </template>
                <v-card style="background:#663399 !important" dark>
                    <v-card-title>
                        <v-img height="70" width="70" class="rounded elevation-5 shrink mt-n6"
                               src="@/assets/purple.png"
                               style="position:fixed">
                            <v-row class="fill-height ma-0" align="center" justify="center">
                                <v-icon dark>mdi-calendar</v-icon>
                            </v-row>
                        </v-img>
                        <div class="text-center py-1 font-weight-light grow font-weight-medium">
                            {{ postFormTitle }}
                        </div>
                    </v-card-title>
                    <v-card-text>
                        <v-form>
                            <v-row no-gutters :justify-md="'space-between'">
                                <v-col cols="12" md="5">
                                    <v-text-field v-model="editedPost.name" label="Nombre"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="5">
                                    <v-checkbox v-model="editedPost.approved" :label="editedPost.approved ? 'Activa' : 'Inactiva'">
                                    </v-checkbox>
                                </v-col>
                            </v-row>
                            <v-textarea auto-grow rows="1" v-model="editedPost.description" label="Descripción"></v-textarea>
                            <v-divider class="my-4"></v-divider>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="pa-6 pt-0">
                        <v-btn large class="error darken-1" dark @click="closePost">Cancelar</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn large class="purple darken-1" dark @click="savePost">Guardar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card-title>
        <v-card-text>
            <v-data-table :headers="postsHeaders" sort-by="deployment" sort-desc :items="posts"
                          item-key="id" fixed-header multi-sort>
                <template v-slot:item.deployment="{item}">
                    <span class="font-weight-light text-capitalize">{{ moment(item.deployment).fromNow() }}</span>
                </template>
                <template v-slot:item.approved="{item}">
                    <v-simple-checkbox disabled v-model="item.approved"></v-simple-checkbox>
                </template>
                <template v-slot:item.actions="{item}">
                    <v-btn @click="editPost(item)" icon color="amber"><v-icon>mdi-image-edit</v-icon></v-btn>
                    <v-btn @click="removePost(item)" icon color="red"><v-icon>mdi-image-remove</v-icon></v-btn>
                </template>
                <template v-slot:no-data>
                    <div>
                        <v-btn rounded text class="pa-2" color="none" large @click="postDialog = !postDialog">
                            Crear el primer post
                            <v-avatar size="30" color="prominent" class="ml-2 pa-1">
                                <v-icon color="purple darken-3">mdi-image-plus</v-icon>
                            </v-avatar>
                        </v-btn>
                    </div>
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>
<script>
    export default {
        data: () => ({
            postDialog: false,
            postFormTitle: 'Crear post',
            postsHeaders: [
                {text: 'Lanzamiento', align: 'center', value: 'deployment', filterable: false},
                {text: 'Nombre', align: 'center', value: 'name'},
                {text: 'Descripción', align: 'center', value: 'description'},
                {text: 'Aprobado', align: 'center', value: 'approved', filterable: false},
                {text: 'Acciones', value: 'actions', sortable: false, filterable: false, align: 'center'},
            ],
            posts: [
                {id: 1, deployment: '2020-07-01T04:40:04.000000Z', name: 'da post 1', description: 'asdf', approved: false, },
                {id: 2, deployment: '2020-07-02T04:40:04.000000Z', name: 'da post 2', description: 'asdf', approved: true, },
                {id: 3, deployment: '2020-05-03T04:40:04.000000Z', name: 'da post 3', description: 'asdf', approved: false, },
                {id: 4, deployment: '2020-03-02T04:40:04.000000Z', name: 'da post 4', description: 'asdf', approved: true, },
            ],
            editedPost:  {},

            versionDialog: false,
            versionsHeaders: [
                {text: 'Título', align: 'center', value: 'title'},
                {text: 'Texto', align: 'center', value: 'text'},
                {text: 'Estado', align: 'center', value: 'status'},
            ],
        }),

        watch: {
            postDialog(val) {
                val || this.closePost()
            },
        },

        methods: {
            savePost() {
                this.closePost()
            },

            editPost(item) {
                this.postDialog = true
                this.postFormTitle = 'Editar post'
                Object.assign(this.editedPost, item)
            },

            closePost() {
                this.postDialog = false
                this.$nextTick(() => {
                    this.editedPost = {}
                    this.postFormTitle = 'Crear post'
                })
            },
        }
    }
</script>
