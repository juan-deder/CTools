import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        user: null
    },
    getters: {},
    mutations: {
        setUser(state, user) {
            state.user = user
        }
    },
    actions: {
        logout() {
            axios.post('https://ctools.mixture.com.co/api/logout')
                .then(() => this.commit('setUser', null))
        },
    },
    modules: {}
})
