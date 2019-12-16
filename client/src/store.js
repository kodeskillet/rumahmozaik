import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    products: null,
    catalogs: null
  },
  getters: {
    products: state => state.products,
    catalogs: state => state.catalogs
  },
  mutations: {
    fillProduct (state, products) {
      state.products = products
    },
    fillCatalog (state, catalogs) {
      state.catalogs = catalogs
    } 
  },
  actions: {
    fillProduct ({commit}, products) {
      commit('fillProduct', products)
    },
    fillCatalog ({commit}, catalogs) {
      commit('fillCatalog', catalogs)
    }
  }
})

export default store

