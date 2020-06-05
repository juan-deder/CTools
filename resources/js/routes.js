import Home from './components/Home'
import Grids from './components/Grids'
import NotFound from './components/NotFound'
import PrivacyPolicy from './components/PrivacyPolicy'

export default {
    mode: 'history',

    linkActiveClass: 'font-bold',

    routes: [
        {
            path: '*',
            component: NotFound,
        }, {
            path: '/',
            component: Home
        }, {
            path: '/grids',
            component: Grids
        }, {
            path: '/privacyPolicy',
            component: PrivacyPolicy
        }
    ]

}
