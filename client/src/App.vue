<template>
  <v-app>
    <v-app-bar app>
      <v-icon @click="showMenu = !showMenu" :class="{active: showMenu}">
        {{ menuIcon }}
      </v-icon>
      <v-spacer></v-spacer>
      <v-toolbar-title class="headline text-uppercase">
        <span class="quote">All About Design</span>
        <span class="font-weight-light separator">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <span class="deep-pink">RUMAH</span>
        <span class="font-weight-light light-pink">MOZAIK</span>
      </v-toolbar-title>
    </v-app-bar>

    <v-card class="menu-list"
            :class="{shown: showMenu}"
            elevation="12"
            width="256">
      <v-navigation-drawer floating permanent>
        <v-list dense rounded>
          <v-list-item v-for="item in menuItems"
                       :key="item.title"
                       @click="navigator(item.navigateTo)"
          >
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
      <router-view/>

      <v-btn fixed dark fab bottom right class="pink-btn">
        <v-badge left>
          <template v-slot:badge>
            <span>2</span>
          </template>
          <v-icon>mdi-cart</v-icon>
        </v-badge>
      </v-btn>
    </v-content>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
      showMenu: false,
      menuIcon: "mdi-menu",
      menuItems: [
        {
          icon: "mdi-home",
          title: "Home",
          navigateTo: "/",
        },
        {
          icon: "mdi-package-variant-closed",
          title: "Products",
          navigateTo: "",
        },
        {
          icon: "mdi-brush",
          title: "Designs",
          navigateTo: "",
        },
        {
          icon: "mdi-information-outline",
          title: "About",
          navigateTo: "/about",
        },
        {
          icon: "mdi-email",
          title: "Contact",
          navigateTo: "",
        },
      ]
    }),
    watch: {
      // eslint-disable-next-line no-unused-vars
      showMenu(newVal, oldVal) {
        if (newVal) {
          this.menuIcon = "mdi-menu-open"
        } else {
          this.menuIcon = "mdi-menu"
        }
      }
    },
    methods: {
      navigator(goto) {
        this.$router.push(goto);
        this.showMenu = false;
      }
    }
  }
</script>

<style>
  .deep-pink {
    color: #e84242;
  }
  .light-pink {
    color: #ee8181;
  }
  .pink-btn {
    background: #fb4444 !important;
  }
</style>

<style scoped>
  .menu-list {
    z-index: 9999;
    position: absolute;
    margin-top: 75px;
    margin-left: 12px;
    opacity: 0;
    transition: all .3s ease-in-out;
  }

  .shown {
    opacity: 1;
  }

  i.active {
    color: #ee8181 !important;
  }

  span.quote {
    font-size: .9rem;
    color: #999 !important;
  }

  span.separator {
    color: #bbb !important;
  }
</style>
