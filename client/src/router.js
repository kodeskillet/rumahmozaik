import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import About from './views/About'
import Product from "./views/Product";
import HowTo from "./views/HowTo";
import Contact from "./views/Contact";

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
      path: '/product',
      name: 'products',
      component: Product,
      meta: { transitionName: 'slide' }
    },
    {
      path: '/howto',
      name: 'howto',
      component: HowTo,
      meta: { transitionName: 'slide' }
    },
    {
      path: '/about',
      name: 'about',
      component: About,
      meta: { transitionName: 'slide' },
    },
    {
      path: '/contact',
      name: 'contact',
      component: Contact,
      meta: { transitionName: 'slide' }
    },
    {
      path: '*',
      redirect: '/',
    }
  ]
})
