import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import About from './views/About'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
      meta: { transitionName: 'slide' },
    },
    {
      path: '/about',
      name: 'about',
      component: About,
      meta: { transitionName: 'slide' },
    },
    {
      path: '*',
      redirect: '/',
    }
  ]
})
