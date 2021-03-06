import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';
import moment from 'moment'
import Avatar from './components/Avatar.vue'

Vue.prototype.moment = moment
moment.locale('es');
Vue.use(require("moment"));

Vue.config.productionTip = false

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true

Vue.component('avatar', Avatar);

new Vue({
    router,
    store,
    vuetify,
    render: function (h) {
        return h(App)
    },
}).$mount('#app')

window.fbAsyncInit = function () {
    FB.init({
        appId: '876513946189146',
        autoLogAppEvents: true,
        xfbml: false, // set to true when there's fb markup
        version: 'v7.0',
        status: true,
        cookie: true
    });
};
