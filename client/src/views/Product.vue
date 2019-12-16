<template>
  <section class="product">
    <!--    Bapak Ayib edit edit disini-->
    <v-row no-gutters>
      <v-container>
        <v-tabs align-with-title background-color="transparent">
          <v-col v-for="n in 3" :key="n" cols="12" sm="4">
            <v-tab class="pink--text">IKI TAB COK SEK STATIS</v-tab>
          </v-col>
        </v-tabs>
        <v-tabs-item>
          <!-- <v-card > -->
          <v-col
            id="scrolling-techniques-3"
            class="overflow-y-auto"
            max-height="600"
            background-color="transparent"
          >
            <v-container>
              <v-col cols="12">
                  <v-container>
                    <v-row>
                      <v-col v-for="n in 30" :key="n" class="d-flex child-flex" cols="4">
                        <v-card flat tile class="d-flex">
                          <v-img
                            :src="`https://picsum.photos/500/300?image=${n * 5 + 10}`"
                            :lazy-src="`https://picsum.photos/10/6?image=${n * 5 + 10}`"
                            aspect-ratio="1"
                            class="grey lighten-2"
                          >
                          </v-img>
                        </v-card>
                      </v-col>
                    </v-row>
                  </v-container>
              </v-col>
            </v-container>
          </v-col>
          <!-- </v-card> -->
        </v-tabs-item>
      </v-container>
    </v-row>
  </section>
</template>

<script>
// Ini ndausah diumek

export default {
  name: "Product"
};
</script>

<style scoped>
/*styling disini*/
</style>
