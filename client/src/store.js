import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    menuItems: [
      {
        icon: "mdi-home",
        title: "Home",
        navigateTo: "/",
      },
      {
        icon: "mdi-package-variant-closed",
        title: "Products",
        navigateTo: "/product",
      },
      {
        icon: "mdi-help-circle",
        title: "How to order",
        navigateTo: "/howto",
      },
      {
        icon: "mdi-information-outline",
        title: "About",
        navigateTo: "/about",
      },
      {
        icon: "mdi-email",
        title: "Contact",
        navigateTo: "/contact",
      },
    ],
    products: null,
    catalogs: null,
    cart: {
      content: [],
      total: 0
    }
  },
  getters: {
    menuItems: state => state.menuItems,
    products: state => state.products,
    catalogs: state => state.catalogs,
    cart: state => state.cart
  },
  mutations: {
    fillProduct (state, products) {
      state.products = products
    },
    fillCatalog (state, catalogs) {
      state.catalogs = catalogs
    },
    setCart (state, cart) {
      state.cart = cart
    }
  },
  actions: {
    fillProduct ({commit}, products) {
      commit('fillProduct', products)
    },
    fillCatalog ({commit}, catalogs) {
      commit('fillCatalog', catalogs)
    },
    setCart ({commit}, cart) {
      commit('setCart', cart)
    }
  }
})

export default store

