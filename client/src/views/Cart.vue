<template>
  <section class="cart">
    <v-row>
      <v-col cols="12" md="4">
        <v-card>
          <v-card-title>
            <span class="title">Order</span>
          </v-card-title>
          <v-card-subtitle>
            <span class="subtitle-2 font-weight-light">Order personal identification</span>
          </v-card-subtitle>
          <v-divider/>
          <v-card-text>

          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="8">
        <v-card>
          <v-card-title>
            <span class="title">Summary</span>
          </v-card-title>
          <v-card-subtitle>
            <span class="subtitle-2 font-weight-light">Your order summary</span>
          </v-card-subtitle>
          <v-divider/>
          <v-card-text>

          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </section>
</template>

<script>
  import {mapState} from 'vuex'

  export default {
    name: "Cart",
    data: () => ({
      user: {},
      cart: {},
    }),
    computed: mapState(['products', 'catalogs', 'order']),
    mounted() {

    },
    methods: {

    }
  }
</script>

<style scoped>

</style>
