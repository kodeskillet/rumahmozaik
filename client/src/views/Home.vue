<template>
  <section class="home">
    <v-carousel hide-delimiters
                cycle
                height="auto"
                class="mb-12"
                :prev-icon="false"
                :next-icon="false"
                style="border-bottom: 1px solid #ddd">
      <v-carousel-item v-for="(item, index) in items"
                       :key="index"
                       v-bind:src="item.src">
      </v-carousel-item>
    </v-carousel>
    <v-container fluid class="mb-12">
      <v-row justify="center">
        <v-col lg="6">
          <h1 class="display-3">
            <span class="deep-pink font-weight-regular">RUMAH</span>
            <span class="light-pink font-weight-thin">MOZAIK</span>
          </h1>
          <p class="display-1 mt-2 font-weight-thin text-right">
            Whatever you need, However you want, In a way you would never expect.
          </p>
          <p class="title mt-12 font-weight-light pr-6 text-right">
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
          <v-img src="/assets/images/logo-roof.png"
                 lazy-src="/assets/images/logo-roof.png"
                 aspect-ratio="1"
                 max-width="700"
                 max-height="250"
                 style="top:35px"/>
        </v-col>
      </v-row>
      <v-row class="mt-12 mb-12 bg-light-pink" justify="center">
        <v-col lg="4" class="pb-0">
          <v-img src="/assets/images/cuscus.png"
                 lazy-src="/assets/images/cuscus.png"
                 aspect-ratio="1"
                 max-width="500"
                 max-height="300"/>
        </v-col>
        <v-col lg="6" style="padding-top: 3%">
          <h2 class>
            <span class="display-2 font-weight-light">Over </span>
            <span class="display-3 deep-pink font-weight-bold">1000+ </span>
            <span class="display-2 font-weight-thin">customers worldwide</span>
          </h2>
          <h2>
            <span class="display-2 font-weight-light">And </span>
            <span class="display-3 deep-blue font-weight-bold">50+ </span>
            <span class="display-2 font-weight-thin">resellers trusted our service</span>
          </h2>
          <h2>
            <span class="display-2 font-weight-light">In </span>
            <span class="display-3 bright-blue font-weight-bold">10+ </span>
            <span class="display-2 font-weight-thin">E - Commerce platforms</span>
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
        {src: '/assets/images/crsl1.jpg'},
        {src: '/assets/images/crsl2.jpg'},
        {src: '/assets/images/crsl3.jpg'},
      ],
      hideDelimiters: true
  }),
}
</script>
