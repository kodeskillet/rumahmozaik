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
      <transition
        name="fade"
        mode="out-in"
        @before-leave="beforeLeave"
        @enter="enter"
        @after-enter="afterEnter"
      >
        <router-view/>
      </transition>

      <v-btn fixed dark fab bottom right class="pink-btn">
        <v-badge left>
          <template v-slot:badge>
            <span>2</span>
          </template>
          <v-icon>mdi-cart</v-icon>
        </v-badge>
      </v-btn>
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
  </v-app>
</template>

<script>
  import {mapState} from 'vuex'
  import Api from "./services/Api";

  export default {
    data: () => ({
      showMenu: false,
      menuIcon: "mdi-menu",
      menuItems: [],
      location: "HOME",
      prevHeight: 0,
      allProducts: null
    }),
    created() {
      this.fillProducts()
      this.fillCatalogs()
      this.menuItems = this.$store.getters.menuItems;
    },
    mounted() {
      setInterval(() => {
        this.fillProducts()
        this.fillCatalogs()
      }, 10000)
    },
    computed: mapState(['products', 'catalogs']),
    watch: {
      // eslint-disable-next-line no-unused-vars
      showMenu(newVal, oldVal) {
        if (newVal) {
          this.menuIcon = "mdi-menu-open"
        } else {
          this.menuIcon = "mdi-menu"
        }
      },
      'products': {
        handler (val) {
          this.allProducts = val
        }, deep: true
      },
      'catalogs': {
        handler (val) {
          this.allCatalogs = val
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
      async fillProducts () {
        const store = this.$store;
        await Api.product.getAll().then(response => {
          store.dispatch('fillProduct', response.data)
        }).catch(err => {
          alert(err)
        })
      },
      async fillCatalogs () {
        const store = this.$store
        await Api.catalog.getAll().then(response => {
          store.dispatch('fillCatalog', response.data)
        }).catch(err => {
          alert(err)
        })
      }
    }
};
</script>

<style>
  html {
    overflow: hidden;
  }
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
