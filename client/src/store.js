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
    order: {
      firstName: null,
      lastName: null,
      email: null,
      phone: null,
      cart: {
        content: [],
        total: 0
      },
    }
  },
  getters: {
    menuItems: state => state.menuItems,
    products: state => state.products,
    catalogs: state => state.catalogs,
    order: state => state.order,
    cart: state => state.order.cart
  },
  mutations: {
    fillProduct (state, products) {
      state.products = products
    },
    fillCatalog (state, catalogs) {
      state.catalogs = catalogs
    },
    setOrder (state, order) {
      state.order.firstName = order.firstName
      state.order.lastName = order.lastName
      state.order.email = order.email
      state.order.phone = order.phone
    },
    setCart (state, cart) {
      state.order.cart.content = cart
      let total = 0
      cart.forEach(el => {
        total += el.amount
      })
      state.order.cart.total = total
    }
  },
  actions: {
    fillProduct ({commit}, products) {
      commit('fillProduct', products)
    },
    fillCatalog ({commit}, catalogs) {
      commit('fillCatalog', catalogs)
    },
    setOrder ({commit}, order) {
      commit('setOrder', order)
    },
    setCart ({commit}, cart) {
      commit('setCart', cart)
    }
  }
})

export default store

