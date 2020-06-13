import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

  const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/Grids',
    name: 'Grids',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: function () {
      return import(/* webpackChunkName: "about" */ '../views/Grids.vue')
    },
  },
  {
    path: '/PrivaCyPolicy',
    name: 'PrivaCyPolicy',
    component: function () {
      return import(/* webpackChunkName: "about" */ '../views/PrivacyPolicy.vue')
    },
  },
  {
    path: '*',
    name: 'NotFound',
    component: function () {
      return import(/* webpackChunkName: "about" */ '../views/NotFound.vue')
    },
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
