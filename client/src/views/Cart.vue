<template>
  <section class="cart">
    <v-row>
      <v-col cols="12" md="4">
        <v-card>
          <v-card-title>
            <span class="title">Order</span>
            <v-spacer/>
            <v-icon v-if="!updateInfo" large color="success">mdi-check-circle</v-icon>
            <v-icon v-if="updateInfo && !userForm.valid" large color="error">mdi-close-circle</v-icon>
          </v-card-title>
          <v-card-subtitle>
            <span class="subtitle-2 font-weight-light">Order personal identification</span>
          </v-card-subtitle>
          <v-divider/>
          <v-card-text>
            <v-form ref="userForm" v-model="userForm.valid" lazy-validation>
              <v-row>
                <v-col cols="12" md="6" sm="6" class="pt-0 pb-0">
                  <v-text-field
                          v-model="user.firstName"
                          label="First Name"
                          :rules="userForm.rules.firstName"
                          required
                          :disabled="!updateInfo"/>
                </v-col>
                <v-col cols="12" md="6" sm="6" class="pt-0 pb-0">
                  <v-text-field
                          v-model="user.lastName"
                          label="Last Name"
                          :rules="userForm.rules.lastName"
                          required
                          :disabled="!updateInfo"/>
                </v-col>
                <v-col cols="12" class="pt-0">
                  <v-text-field
                          v-model="user.email"
                          label="Email"
                          :rules="userForm.rules.email"
                          required
                          :disabled="!updateInfo"/>
                </v-col>
                <v-col cols="12" class="pt-0">
                  <v-text-field
                          v-model="user.phone"
                          label="Phone Number"
                          :rules="userForm.rules.phone"
                          hint="Please make sure this number is attached to Whatsapp Messenger"
                          persistent-hint
                          required
                          :disabled="!updateInfo"/>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
          <v-divider class="mx-auto"/>
          <v-card-actions>
            <v-spacer/>
            <v-btn v-if="!updateInfo"
                   color="info"
                   @click="updateInfo = true">
              Update
            </v-btn>
            <v-btn v-if="updateInfo"
                   color="success lighten-1"
                   :disabled="disableSave"
                   @click="updateUserInfo">
              Save
            </v-btn>
            <v-btn v-if="updateInfo"
                   color="red lighten-1"
                   class="white--text"
                   @click="resetUserInfo">
              Reset
            </v-btn>
            <v-spacer/>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="12" md="8">
        <v-card>
          <v-card-title>
            <span class="title">Summary</span>
            <v-spacer/>
            <v-icon v-if="orderConfirmed" large color="success">mdi-check-circle</v-icon>
          </v-card-title>
          <v-card-subtitle>
            <span class="subtitle-2 font-weight-light">Your order summary</span>
          </v-card-subtitle>
          <v-divider/>
          <v-card-text class="pr-8 pl-8 pt-0 pb-0" style="overflow-x: auto; max-height: 250px">
            <p v-if="cart === null || cart.length < 1" class="text-center font-italic mt-12 pb-12">
              <span class="display-3 font-weight-bold deep-pink">Uh-oh!</span><br/>
              <span class="headline font-weight-thin">You have an empty cart.</span><br/>
              <span class="title font-weight-light">Go ahead and pick one of our products!</span>
            </p>
            <div v-if="cart !== null && cart.length >= 1">
              <v-row v-for="(el, index) in cart" :key="index">
                <v-col cols="12">
                  <v-card raised>
                    <v-row>
                      <v-col cols="12" md="4" class="pt-0 pb-0 pr-0">
                        <v-img :src="`${imgBaseUrl}/${el.detail.picture}`"
                               :lazy-src="`${imgBaseUrl}/${el.detail.picture}`"
                               aspect-ratio="1"
                               class="grey lighten-2"
                               style="border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
                          <template v-slot:placeholder>
                            <v-row class="fill-height ma-0"
                                   align="center"
                                   justify="center">
                              <v-progress-circular indeterminate color="grey lighten-4">
                              </v-progress-circular>
                            </v-row>
                          </template>
                        </v-img>
                      </v-col>
                      <v-col cols="12" md="8" class="pl-0 my-auto" >
                        <v-card flat>
                          <v-card-title>
                          <span class="display-2 font-weight-light grey--text text--lighten-1">
                            {{ el.detail.productName }}
                          </span>
                            <v-spacer/>
                            <span class="display-3 font-weight-thin deep-pink">
                            x {{el.amount}}
                          </span>
                          </v-card-title>
                          <v-card-subtitle>
                          <span class="headline font-weight-bold">
                            Rp. {{format(el.detail.price)}}
                          </span>
                          </v-card-subtitle>
                          <v-spacer/>
                          <v-divider class="mx-auto"/>
                          <v-card-text class="pt-0 pb-0 grey lighten-3">
                            <v-row>
                              <v-col cols="12" md="3" class="text-right">
                                <span class="font-weight-bold">Sub-total :</span>
                              </v-col>
                              <v-col cols="12" md="9">
                              <span class="headline font-weight-bold red--text">
                                Rp. {{ format(el.detail.price * el.amount) }},-
                              </span>
                              </v-col>
                            </v-row>
                          </v-card-text>
                          <v-divider class="mx-auto"/>
                          <v-card-actions>

                          </v-card-actions>
                        </v-card>
                      </v-col>
                    </v-row>
                  </v-card>
                </v-col>
              </v-row>
            </div>
          </v-card-text>
          <v-divider v-if="cart !== null && cart.length >= 1" class="mx-auto"/>
          <v-card-text v-if="cart !== null && cart.length >= 1">
            <v-row class="pt-0 mt-0 pb-0 mb-0">
              <v-col cols="12" md="7" class="text-right">
                <span class="title font-weight-bold">Total : </span>
              </v-col>
              <v-col cols="12" md="5">
                <span class="display-1 font-weight-bold red--text darken-1">
                  Rp. {{ getTotal() }},-
                </span>
              </v-col>
            </v-row>
          </v-card-text>
          <v-divider v-if="cart !== null && cart.length >= 1" class="mx-auto"/>
          <v-card-actions v-if="cart !== null && cart.length >= 1" class="pr-6 pl-6">
            <v-checkbox v-model="orderConfirmed" label="I here by confirm my order."/>
            <v-spacer/>
            <v-btn color="success lighten-1"
                   :disabled="!orderConfirmed">
              Let's go
              <v-icon>mdi-chevron-right</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>

    <v-snackbar v-model="snackbar.state"
                :timeout="snackbar.timeout"
                :color="snackbar.color || 'primary'"
                :multi-line="snackbar.multiline"
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
    name: "Cart",
    data: () => ({
      imgBaseUrl: `${Api.baseUrl}/storage/products`,
      allProducts: null,
      user: {
        firstName: null,
        lastName: null,
        email: null,
        phone: null,
      },
      userForm: {
        valid: true,
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        rules: {
          firstName: [
            v => !!v || 'First Name is required',
          ],
          lastName: [
            v => !!v || 'Last Name is required',
          ],
          email: [
            v => !!v || 'Email is required',
            v => /.+@.+\..+/.test(v) || 'Email must be a valid Email address',
          ],
          phone: [
            v => !!v || 'Phone Number is required',
            v => /^[0-9]+$/.test(v) || 'Phone Number needs to be numbers',
          ]
        }
      },
      cart: null,
      updateInfo: false,
      disableSave: false,
      orderConfirmed: false,
      snackbar: {
        state: false,
        multiline: false,
        color: '',
        text: '',
        timeout: 0
      }
    }),
    computed: mapState(['products', 'order']),
    mounted() {
      this.allProducts = this.$store.getters.products
      let order = this.$store.getters.order
      this.user = {
        firstName: order.firstName,
        lastName: order.lastName,
        email: order.email,
        phone: order.phone
      }
      let cart = this.$store.getters.cart
      this.cart = this.filterCart(cart.content)
    },
    watch: {
      'order': {
        handler (val) {
          this.user = {
            firstName: val.firstName,
            lastName: val.lastName,
            email: val.email,
            phone: val.phone
          }
        }, deep: true
      },
      'order.cart.content': {
        handler (val) {
          this.cart = this.filterCart(val)
        }
      },
      'user': {
        handler (val) {
          this.userForm.firstName = val.firstName
          this.userForm.lastName = val.lastName
          this.userForm.email = val.email
          this.userForm.phone = val.phone
        }, deep: true
      },
      'userForm.valid': {
        handler (val) {
          this.disableSave = !val;
        }, deep: true
      }
    },
    methods: {
      filterCart (cart) {
        let c = cart
        let products = this.allProducts
        c.forEach((el, index) => {
          products.forEach(product => {
            if (el.productId === product.id) {
              c[index]["detail"] = product
            }
          })
        })
        // eslint-disable-next-line no-console
        return c;
      },
      resetUserInfo () {
        let user = this.$store.getters.order
        this.user = {
          firstName: user.firstName,
          lastName: user.lastName,
          email: user.email,
          phone: user.phone
        }
        this.$refs.userForm.resetValidation()
      },
      updateUserInfo () {
        let order = this.user
        this.$store.dispatch('setOrder', order)
        this.updateInfo = false
        this.snackbar = {
          state: true,
          multiline: false,
          color: 'success',
          text: 'Personal info updated!',
          timeout: 3000
        }
      },

      getTotal () {
        let cart = this.cart
        let total = 0
        cart.forEach(el => {
          total += el.detail.price * el.amount
        })
        return this.format(total)
      },
      format (num) {
        return (num).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
      }
    }
  }
</script>

<style scoped>

</style>
