import Vue from 'vue';
import Vuetify from 'vuetify/lib';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        themes: {
            light: {
                prominent: '#ffffff',
                secondary: '#b0bec5',
                tertiary: '#F2F2F2'
            },
            dark: {
                prominent: '#1e1e1e',
                tertiary: '#202020'
            },
        },
    }
});
