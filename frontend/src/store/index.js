import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        user: null
    },
    getters: {
        nameInitials (state) {
            return state.user.name.split(' ').map((name) => name[0]).join('')
        }
    },
    mutations: {
        setUser(state, user) {
            state.user = user
        },
    },
    actions: {},
    modules: {}
})
