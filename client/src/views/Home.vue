<template>
  <section class="home">
    <v-carousel hide-delimiters cycle show-arrows-on-hover height="auto" class="mb-12">
      <v-carousel-item v-for="(item, index) in items"
                       :key="index"
                       v-bind:src="item.src">
      </v-carousel-item>
    </v-carousel>
    <v-container fluid class="mb-12">
      <v-row justify="center">
        <v-col lg="6">
          <h1 class="display-4">
            <span class="deep-pink font-weight-regular">RUMAH</span>
            <span class="light-pink font-weight-thin">MOZAIK</span>
          </h1>
          <p class="display-1 mt-2 font-weight-thin text-right">
            Whatever you need, However you want, In a way you would never expect.
          </p>
          <p class="title mt-10 font-weight-light pr-6 text-right">
            In
            <span class="deep-blue font-weight-bold">RUMAH</span>
            <span class="bright-blue">MOZAIK</span>, we explore the best approach to <br/>
            fulfill your needs for any events, occasions, and celebrations.
          </p>

          <p class="title mt-2 font-weight-light pr-12 text-right">
            We create the most beautiful work of art within the digital universe<br/>
            penetrating the boundaries between art and science and making the two even.
          </p>
        </v-col>
        <v-col lg="4">
          <v-img src="/assets/logo-roof.png"
                 lazy-src="/assets/logo-roof.png"
                 aspect-ratio="1"
                 max-width="700"
                 max-height="250"
                 style="top:35px"/>
        </v-col>
      </v-row>
      <v-row class="mt-12 bg-light-pink" justify="center">
        <v-col lg="4" class="pb-0">
          <v-img src="/assets/cuscus.png"
                 lazy-src="/assets/cuscus.png"
                 aspect-ratio="1"
                 max-width="500"
                 max-height="300"/>
        </v-col>
        <v-col lg="6" style="padding-top: 5%">
          <h2 class>
            <span class="display-2 font-weight-light">Over </span>
            <span class="display-3 deep-blue font-weight-bold">100.000+ </span>
            <span class="display-2 font-weight-light">customers</span>
          </h2>
          <h2>
            <span class="display-2 font-weight-light">And </span>
            <span class="display-3 bright-blue font-weight-bold">50+ </span>
            <span class="display-2 font-weight-light">resellers have trusted our service</span>
          </h2>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

<script>

export default {
  name: 'home',
  data: () => ({
      items: [
        {src: '/assets/crsl1.jpg'},
        {src: '/assets/crsl2.jpg'},
        {src: '/assets/crsl3.jpg'},
      ],
      hideDelimiters: true
  }),
}
</script>
