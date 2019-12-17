<template>
  <section class="product mb-12 pb-12">
    <v-tabs center-active background-color="blue-grey lighten-5" light grow class="fixed-tabs-bar">
      <v-tab v-for="(catalog, index) in allCatalogs" class="pink--text text--darken-3" :key="index" :href="`#tab-${index}`">
        <v-badge right>
          <template v-if="amountCatalog(catalog.id) > 0" v-slot:badge>
            <span>{{ amountCatalog(catalog.id) }}</span>
          </template>
          <span>{{ catalog.name }}</span>
        </v-badge>
      </v-tab>
      <v-tab-item v-for="(catalog, index) in allCatalogs" :key="index" :value="'tab-'+index">
        <v-container>
          <v-row>
            <v-col v-if="filterProducts(catalog.id).length === 0" class="text-center" style="margin-top: 10%">
              <p class="deep-pink font-weight-bold display-4 font-italic">Oops!</p>
              <p class="font-italic">
                <span class="display-1 font-weight-thin">Our </span>
                <span class="display-1 font-weight-regular light-pink"><u>{{catalog.name}}</u>&nbsp;</span>
                <span class="display-1 font-weight-thin">products is not yet available. </span><br/>
                <span class="headline font-weight-thin">Please check again next time.</span>
              </p>
            </v-col>
            <v-col v-else
                   v-for="(product, index) in filterProducts(catalog.id)"
                   :key="index"
                   class="pt-8"
                   cols="3">
              <v-card raised class="mx-auto">
                <v-img :src="`${imgBaseUrl}/${product.picture}`"
                       :lazy-src="`${imgBaseUrl}/${product.picture}`"
                       aspect-ratio="1"
                       class="grey lighten-2">
                  <template v-slot:placeholder>
                    <v-row class="fill-height ma-0"
                           align="center"
                           justify="center">
                      <v-progress-circular indeterminate color="grey lighten-4">
                      </v-progress-circular>
                    </v-row>
                  </template>
                </v-img>
                <v-card-text>
                  <p>
                    <span class="font-weight-thin display-1">{{product.productName}}</span>
                    <span v-if="amount(product.id)" class="font-weight-bold title pink--text text--lighten-3">
                      &nbsp;x
                      {{amount(product.id)}}
                    </span>
                  </p>
                  <v-chip color="pink lighten-5" pill>
                    <v-avatar left color="grey">
                      <span class="font-weight-bold white--text">Rp.</span>
                    </v-avatar>
                    <span class="font-weight-regular">{{format(product.price)}}</span>
                  </v-chip>
                </v-card-text>
                <v-divider class="mx-auto"/>
                <v-card-actions>
                  <v-spacer v-if="!amount(product.id)"/>
                  <v-btn v-if="!amount(product.id)"
                         color="green lighten-2"
                         class="white--text"
                         raised @click="addToCart(product.id)">
                    <v-icon>mdi-cart</v-icon>
                    &nbsp;Add to cart
                  </v-btn>
                  <v-btn v-if="amount(product.id)"
                         color="red darken-1"
                         class="white--text"
                         raised @click="removeFromCart(product.id)">
                    <v-icon>mdi-delete</v-icon>
                    &nbsp;Remove from cart
                  </v-btn>
                  <v-spacer/>
                  <v-btn v-if="amount(product.id)"
                         color="red lighten-1"
                         class="white--text"
                         @click="reduceItem(product.id)">
                    <v-icon>mdi-minus</v-icon>
                  </v-btn>
                  <v-btn v-if="amount(product.id)"
                         color="primary lighten-2"
                         class="white--text"
                         @click="addToCart(product.id)">
                    <v-icon>mdi-plus</v-icon>
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-tab-item>
    </v-tabs>

    <v-snackbar v-model="snackbar.state"
                :timeout="snackbar.timeout"
                :color="snackbar.color || 'primary'"
                top>
      {{ snackbar.text }}
      <v-btn dark text @click="snackbar.state = false">
        Close
      </v-btn>
    </v-snackbar>
  </section>
</template>

<script>
import {mapState} from 'vuex'
import Api from '../services/Api'

export default {
  name: "Product",
  data: () => ({
    imgBaseUrl: `${Api.baseUrl}/storage/products`,
    allProducts: null,
    allCatalogs: null,
    currentCart: [],
    snackbar: {
      state: false,
      color: '',
      text: '',
      timeout: 0,
    }
  }),
  mounted() {
    this.allProducts = this.$store.getters.products
    this.allCatalogs = this.$store.getters.catalogs
    let cart = this.$store.getters.cart
    this.currentCart = cart.content.map(el => el)
  },
  computed: mapState(['products', 'catalogs', 'order']),
  watch: {
    'products': {
      handler (val) {
        this.allProducts = val
      }, deep: true
    },
    'catalogs': {
      handler (val) {
        this.allCatalogs = val
      }, deep: true
    },
    'order.cart.content': {
      handler (val) {
        this.currentCart = val
      }, deep: true
    }
  },
  methods: {
    filterProducts (catalogId) {
      let products = this.allProducts
      return products.filter(product => product.catalogType === catalogId)
    },
    addToCart (productId) {
      let cart = this.currentCart
      if (this.currentCart.length === 0) {
        cart.push({
          productId: productId,
          amount: 1
        })
      } else {
        let tmpIndex = null
        cart.some((el, index) => {
          if (el.productId === productId) {
            tmpIndex = index
          }
        })
        if (tmpIndex != null) {
          cart[tmpIndex].amount += 1
        } else {
          cart.push({
            productId: productId,
            amount: 1
          })
        }
      }
      this.$store.dispatch('setCart', cart)
      this.snackbar = {
        state: true,
        text: 'Added to cart.',
        color: 'success',
        timeout: 3000
      }
    },
    reduceItem (productId) {
      let cart = this.currentCart
      let tmpIndex = 0
      let tmpAmount = 0
      cart.forEach((el, index) => {
        if (el.productId === productId) {
          tmpIndex = index
          tmpAmount = el.amount
        }
      })

      if (tmpAmount === 1) {
        cart = this.currentCart.filter(el => {
          return (el.productId !== productId)
        })
        this.snackbar = {
          state: true,
          text: 'Removed from cart.',
          color: 'info',
          timeout: 3000
        }
      } else {
        cart[tmpIndex].amount--
        this.snackbar = {
          state: true,
          text: 'Amount reduced.',
          color: 'info',
          timeout: 3000
        }
      }
      this.$store.dispatch('setCart', cart)
    },
    removeFromCart (productId) {
      let cart = this.currentCart.filter(el => {
        return (el.productId !== productId)
      })
      this.$store.dispatch('setCart', cart)
      this.snackbar = {
        state: true,
        text: 'Removed from cart.',
        color: 'error',
        timeout: 3000
      }
    },

    amount (productId) {
      let data = this.currentCart.find(el => el.productId === productId)
      if (data) {
        const objData = JSON.parse(JSON.stringify(data))
        return objData.amount
      }
    },
    amountCatalog (catalogId) {
      let cart = this.currentCart
      let amount = 0
      cart.forEach(el => {
        this.allProducts.forEach(product => {
          if (el.productId === product.id ) {
            if (product.catalogType === catalogId) {
              amount += 1
            }
          }
        })
      })
      return amount
    },
    format (num) {
      return (num).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
  },

};
</script>

<style>
  .fixed-tabs-bar .v-tabs-bar {
    position: -webkit-sticky !important;
    position: sticky !important;
    top: 4rem !important;
    z-index: 2 !important;
    -webkit-box-shadow: 0px 2px 4px -1px rgba(0, 0, 0, 0.2), 0px 4px 5px 0px rgba(0, 0, 0, 0.14), 0px 1px 10px 0px rgba(0, 0, 0, 0.12);
    box-shadow: 0px 2px 4px -1px rgba(0, 0, 0, 0.2), 0px 4px 5px 0px rgba(0, 0, 0, 0.14), 0px 1px 10px 0px rgba(0, 0, 0, 0.12);
  }
  .v-tabs-slider-wrapper {
    height: 3px !important
  }
</style>

<style scoped>

</style>
