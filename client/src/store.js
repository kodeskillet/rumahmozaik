import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    products: {},
    catalogs: {}
  },
  getters: {
    products: state => state.products,
    catalogs: state => state.catalogs
  },
  mutations: {

  },
  actions: {

  }
})

export default store

