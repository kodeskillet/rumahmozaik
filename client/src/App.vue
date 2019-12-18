<template>
  <v-app>
    <v-app-bar app>
      <div class="menu-section" @click="showMenu = !showMenu">
        <div @click="showMenu = !showMenu">
          <v-icon @click="showMenu = !showMenu" :class="{active: showMenu}">{{ menuIcon }}</v-icon>
        </div>
        <div class="location-indicator">
          <v-toolbar-title class="text-uppercase" :class="{active: showMenu}">
            <span style="font-size: 1.2rem">{{ location }}</span>
          </v-toolbar-title>
        </div>
      </div>
      <v-spacer/>
      <v-toolbar-title class="headline text-uppercase">
        <span class="quote">
          By
          <span class="deep-blue font-weight-bold">Hesti</span>
          to
          <span class="bright-blue font-weight-bold">The World</span>
        </span>
        <span class="font-weight-light separator">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <span class="deep-pink">RUMAH</span>
        <span class="font-weight-light light-pink">MOZAIK</span>
      </v-toolbar-title>
    </v-app-bar>

    <v-card class="menu-list" :class="{shown: showMenu}" elevation="12" width="256">
      <v-navigation-drawer floating permanent>
        <v-list dense rounded>
          <v-list-item v-for="item in menuItems" :key="item.title" @click="navigator(item)">
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
    </v-card>

    <v-content @click.native="showMenu = false">
      <div class="loading" :class="{'hidden': loaded}" style="padding-top: 200px">
        <v-row justify="center" align="center">
          <div class="text-center ma-12">
            <v-progress-circular indeterminate
                                 :size="50"
                                 color="primary">
            </v-progress-circular>
          </div>
        </v-row>
      </div>
      <transition
        name="fade"
        mode="out-in"
        @before-leave="beforeLeave"
        @enter="enter"
        @after-enter="afterEnter"
      >
        <router-view/>
      </transition>

      <v-footer absolute class="pt-8 pb-5" style="background-color: initial">
        <v-row justify="center" no-gutters>
          <v-col class="py-4 text-center" cols="12">
            <v-icon>mdi-copyright</v-icon>
            <span class="font-weight-bold">{{ new Date().getFullYear() }}.</span>
            <a href="https://github.com/kodeskillet" target="_blank">
              <code>kodeskillet.</code>
            </a>
          </v-col>
        </v-row>
      </v-footer>
    </v-content>

    <v-btn fixed dark fab bottom right class="pink-btn" @click="dispatchUserInfo">
      <v-badge left>
        <template v-if="totalCart > 0" v-slot:badge>
          <span>{{ totalCart }}</span>
        </template>
        <v-icon>mdi-cart</v-icon>
      </v-badge>
    </v-btn>

    <v-dialog v-model="userInfo.dialogState" persistent max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Quick Intro</span>
        </v-card-title>
        <v-card-subtitle>
          <span class="subtitle-2 font-weight-light">Please tell us about yourself!</span>
        </v-card-subtitle>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                <v-text-field v-model="userInfo.firstName" label="First Name" required/>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field v-model="userInfo.lastName" label="Last Name" required/>
              </v-col>
              <v-col cols="12">
                <v-text-field v-model="userInfo.email" label="Email" required/>
              </v-col>
              <v-col cols="12">
                <v-text-field v-model="userInfo.phone"
                              label="Phone Number"
                              hint="Please provide phone number that attached to Whatsapp Messenger"
                              required/>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider class="mx-auto"/>
        <v-card-actions>
          <v-spacer/>
          <v-btn color="red darken-1"
                 class="white--text"
                 @click="userInfo.dialogState = false">
            Cancel
          </v-btn>
          <v-btn color="success"
                 class="white--text"
                 @click="dispatchCart">
            Proceed
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="cartDialog" max-width="1200px">
      <v-card>
        <v-card-title>
          <v-spacer/>
          <v-btn class="red--text darken-1" icon @click="cartDialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <Cart/>
        </v-card-text>
      </v-card>
    </v-dialog>

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
  </v-app>
</template>

<script>
  import {mapState} from 'vuex'
  import Api from "./services/Api";
  import Cart from "./views/Cart";

  export default {
    components: {Cart},
    data: () => ({
      showMenu: false,
      loaded: false,
      menuIcon: "mdi-menu",
      menuItems: [],
      location: "HOME",
      prevHeight: 0,
      totalCart: 0,
      userInfo: {
        dialogState: false,
        firstName: '',
        lastName: '',
        email: '',
        phone: ''
      },
      cartDialog: false,
      snackbar: {
        state: false,
        multiline: false,
        color: '',
        text: '',
        timeout: ''
      }
    }),
    created() {
      this.fillProducts()
      this.fillCatalogs()
      this.menuItems = this.$store.getters.menuItems;
      let order = this.$store.getters.order
      this.totalCart = order.cart.total
    },
    mounted() {
      setInterval(() => {
        this.fillProducts()
        this.fillCatalogs()
      }, 10000)
      setTimeout(() => {
        this.loaded = true
      }, 2000)
    },
    computed: mapState(['products', 'catalogs', 'order']),
    watch: {
      // eslint-disable-next-line no-unused-vars
      showMenu(newVal, oldVal) {
        if (newVal) {
          this.menuIcon = "mdi-menu-open"
        } else {
          this.menuIcon = "mdi-menu"
        }
      },
      '$route': {
        handler() {
          this.loaded = false
          setTimeout(() => {
            this.loaded = true
          }, 2000)
        }, deep: true
      },
      'order.cart': {
        handler (val) {
          this.totalCart = val.total
        }, deep: true
      }
    },
    methods: {
      navigator(page) {
        this.$router.push(page.navigateTo);
        this.showMenu = false;
        this.location = page.title;
      },
      beforeLeave(element) {
        this.prevHeight = getComputedStyle(element).height;
      },
      enter(element) {
        const { height } = getComputedStyle(element);

        element.style.height = this.prevHeight;

        setTimeout(() => {
          element.style.height = height;
        });
      },
      afterEnter(element) {
        element.style.height = "auto";
      },
      dispatchUserInfo() {
        this.userInfo.dialogState = true
      },
      dispatchCart() {
        this.userInfo.dialogState = false
        this.cartDialog = true
      },
      async fillProducts () {
        const store = this.$store;
        await Api.product.getAll().then(response => {
          store.dispatch('fillProduct', response.data)
        }).catch(err => {
          this.snackbar = {
            state: false,
            multiline: false,
            color: 'error',
            text: `<b>productError</b><br/>${err}`,
            timeout: '3000'
          }
        })
      },
      async fillCatalogs () {
        const store = this.$store
        await Api.catalog.getAll().then(response => {
          store.dispatch('fillCatalog', response.data)
        }).catch(err => {
          this.snackbar = {
            state: false,
            multiline: false,
            color: 'error',
            text: `<b>catalogTypeError</b><br/>${err}`,
            timeout: '3000'
          }
        })
      }
    }
};
</script>

<style>
  .deep-pink {
    color: #e84242;
  }
  .light-pink {
    color: #ee8181;
  }
  .deep-blue {
    color: #3c8dba !important;
  }
  .bright-blue {
    color: #91c9e2 !important;
  }
  .pink-btn {
    background: #fb4444 !important;
  }
  .bg-light-pink {
    background-color: #eea6a6 !important;
  }
  .loading {
    height: 100%;
    width: 100%;
    position: absolute;
    z-index: 999;
    left: 0;
    top: 0;
    background-color: #fff;
    overflow: hidden;
    visibility: visible;
    opacity: 1;
    transition:opacity 0.5s linear;
  }
  .loading.hidden {
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s 0.5s, opacity 0.5s linear;
  }
</style>

<style scoped>
  .menu-list {
    z-index: 9999;
    position: fixed;
    margin-top: 75px;
    margin-left: 12px;
    opacity: 1;
    left: -270px;
    transition: all .2s ease-in-out;
  }

  .shown {
    opacity: 1;
    left: 0;
  }

  .active {
    color: #ee8181 !important;
  }

  span.quote {
    font-size: .9rem;
    color: #999 !important;
  }

  span.separator {
    color: #bbb !important;
  }

  .menu-section {
    display: flex;
    padding: 10px
  }

  .menu-section div {
    display: inline-flex;
    cursor: pointer;
  }

  .location-indicator {
    margin-left: 10px;
  }

  .fade-enter-active,
  .fade-leave-active {
    transition-duration: 0.3s;
    transition-property: opacity;
    transition-timing-function: ease;
    overflow: hidden;
  }

  .fade-enter,
  .fade-leave-active {
    opacity: 0
  }
</style>
