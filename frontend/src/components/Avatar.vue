<template>
    <component :is="wrapper ? wrapper : 'v-avatar'" :color="userColor" class="white--text" v-bind="props">
        <template v-if="userColor">
            {{ nameInitials }}
        </template>
        <v-img v-else :src="user.profile_image"></v-img>
    </component>
</template>
<script>
    import {VAvatar, VListItemAvatar} from 'vuetify/lib'

    export default {
        props: ['user', 'props', 'wrapper'],

        components: {VAvatar, VListItemAvatar},

        data: function () {
            return {}
        },
        computed: {
            nameInitials: function() {
                return this.user.name.split(' ').map((name) => name[0]).join('')
            },
            userColor: function() {
                return this.user.profile_image.startsWith('#') ? this.user.profile_image : ''
            }
        }
    }
</script>
