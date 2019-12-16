<template>
  <section class="home">
    <v-carousel hide-delimiters cycle show-arrows-on-hover>
      <v-carousel-item v-for="(color, i) in colors"
                       :key="color">
        <v-sheet :color="color"
                height="100%"
                tile>
          <v-row class="fill-height"
                 align="center"
                 justify="center">
            <div class="display-3">Item {{ i + 1 }}</div>
          </v-row>
        </v-sheet>
      </v-carousel-item>
    </v-carousel>
  </section>
</template>

<script>

export default {
  name: 'home',
  data: () => ({
      colors: ["red", "green", "yellow"],
      hideDelimiters: true
  }),
}
</script>
