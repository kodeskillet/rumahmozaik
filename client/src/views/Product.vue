<template>
  <section class="product">
<!--    <v-container>-->
      <v-tabs center-active background-color="blue-grey lighten-4" light grow class="fixed-tabs-bar">
        <v-tab v-for="(catalog, index) in allCatalogs" class="blue--text text--darken-3" :key="index" :href="`#tab-${index}`">
          {{ catalog.name }}
        </v-tab>
        <v-tab-item v-for="(catalog, index) in allCatalogs" :key="index" :value="'tab-'+index">
          <v-container>
            <v-row>
              <v-col v-if="filterProducts(catalog.id).length === 0" class="text-center pt-12 pb-12" style="margin: 12.5% 0 12.5% 0">
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
                     class="d-flex child-flex pt-8"
                     cols="4">
                <v-card flat tile class="d-flex">
                  <v-img :src="`${imgBaseUrl}/${product.picture}`"
                         :lazy-src="`${imgBaseUrl}/${product.picture}`"
                         aspect-ratio="1"
                         class="grey lighten-2"/>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </v-tab-item>
      </v-tabs>
<!--    </v-container>-->
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
