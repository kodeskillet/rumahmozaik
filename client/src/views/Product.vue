<template>
  <section class="product mb-12 pb-12">
    <v-tabs center-active background-color="blue-grey lighten-5" light grow class="fixed-tabs-bar">
      <v-tab v-for="(catalog, index) in allCatalogs" class="blue--text text--darken-3" :key="index" :href="`#tab-${index}`">
        {{ catalog.name }}
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
                    <span class="font-weight-bold title pink--text text--lighten-3">
                      &nbsp;x
                      1
                    </span>
                  </p>
                  <v-chip color="pink lighten-5" pill>
                    <v-avatar left color="grey">
                      <span class="font-weight-bold white--text">Rp.</span>
                    </v-avatar>
                    <span class="font-weight-regular">{{format(product.price)}}</span>
                  </v-chip>
                </v-card-text>
                <v-divider class="mx-auto"></v-divider>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn  color="red lighten-2"
                          class="white--text"
                         raised>
                    <v-icon>mdi-cart</v-icon>
                    &nbsp;Add to cart
                  </v-btn>
                  <v-spacer></v-spacer>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-tab-item>
    </v-tabs>
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
  }),
  mounted() {
    this.allProducts = this.$store.getters.products
    this.allCatalogs = this.$store.getters.catalogs
  },
  computed: mapState(['products', 'catalogs']),
  watch: {
    'products': {
      handler (val) {
        this.allProducts = val
      }, deep: true
    },
    'catalogs': {
      handler (val) {
        this.allCatalogs = val
      },deep: true
    }
  },
  methods: {
    filterProducts (catalogId) {
      let products = this.allProducts
      return products.filter(product => product.catalogType === catalogId)
    },
    addToCart (product) {

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
