<script setup lang="ts">
import 'swiper/css/bundle'

import Swiper from 'swiper'
import { onMounted, ref } from 'vue'
import {
  Autoplay,
  Navigation,
  Pagination,
} from 'swiper/modules'
import type { SwiperOptions } from 'swiper/types'

defineProps<{ images?: { image: string }[] }>()

const slider = ref<HTMLElement | null>(null)
const swiperOptions: SwiperOptions = {
  direction: 'horizontal',
  slidesPerView: 1,
  speed: 850,
  spaceBetween: 10,
  loop: true,

  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  modules: [Navigation, Pagination, Autoplay],
}

onMounted(() => {
  if (slider.value) {
    // eslint-disable-next-line no-new
    new Swiper(slider.value, swiperOptions)
  }
})
</script>

<template>
  <div ref="slider" class="swiper-container">
    <div class="swiper-wrapper">
      <img v-for="img in images" :key="img.image" loading="lazy" class="swiper-slide" :src="img.image" :alt="img.image">
    </div>

    <button class="swiper-button-prev swiper-button">
      <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M16 28L8 20L16 12" stroke="white" stroke-opacity="0.75" stroke-width="2" stroke-linecap="square"
          stroke-linejoin="round"
        />
      </svg>
    </button>
    <button class="swiper-button-next swiper-button">
      <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M24 12L32 20L24 28" stroke="white" stroke-opacity="0.75" stroke-width="2" stroke-linecap="square"
          stroke-linejoin="round"
        />
      </svg>
    </button>
    <div class="swiper-pagination" />
  </div>
</template>

<style scoped lang="scss">
.swiper-container {
  overflow: hidden;
  position: relative;
  max-width: 616px;
  max-height: 411px;
  border-radius: $cover-8;
}

.swiper-pagination {
  max-width: 272px;
  display: flex;
  bottom: 12px;
  left: 25%;
  right: auto;
}

.swiper-wrapper {
  backdrop-filter: blur(8px);
}
</style>
