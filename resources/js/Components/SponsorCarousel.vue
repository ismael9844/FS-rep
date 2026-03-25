<template>
  <div v-if="sponsors.length" class="carousel-wrapper">
    <h2 class="carousel-title">
      Partenaires {{ formattedLevel }}
    </h2>
    <VueSlickCarousel :arrows="true" :dots="false" :autoplay="true" :slidesToShow="4">
      <div v-for="sponsor in sponsors" :key="sponsor.id" class="sponsor-slide">
        <img :src="sponsor.logo_url" :alt="sponsor.name" class="sponsor-logo" />
      </div>
    </VueSlickCarousel>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import VueSlickCarousel from 'vue-slick-carousel'

const props = defineProps({
  sponsors: Array,
  level: String
})

const formattedLevel = computed(() => {
  return props.level.charAt(0).toUpperCase() + props.level.slice(1)
})
</script>

<style scoped>
.carousel-wrapper {
  margin: 40px 0;
}
.carousel-title {
  font-size: 24px;
  margin-bottom: 16px;
  text-transform: uppercase;
}
.sponsor-slide {
  padding: 10px;
  text-align: center;
}
.sponsor-logo {
  max-height: 80px;
  max-width: 100%;
  object-fit: contain;
}
</style>
