<script setup lang="ts">
import 'swiper/css/bundle'
import '#/assets/scss/swiper.scss'

import Swiper from 'swiper'
import { onMounted, ref } from 'vue'
import {
  Autoplay,
  Navigation,
  Pagination,
} from 'swiper/modules'
import type { SwiperOptions } from 'swiper/types'
import Next from '#/assets/svg/shared/swiper-next.svg?component'
import Prev from '#/assets/svg/shared/swiper-prev.svg?component'

defineProps<{
  images?: {
    image: string
  }[]
}>()

const stores = setupStore('quest')

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
      <template v-if="images && images.length > 0">
        <img
          v-for="img in images"
          :key="img.image"
          v-lazy-src="img.image"
          loading="lazy"
          class="swiper-slide loading-lazy"
          :alt="img.image"
        >
      </template>
      <template v-else>
        <img v-lazy-src="stores.quest?.cover" :alt="stores.quest?.cover">
      </template>
    </div>

    <button class="swiper-button-prev swiper-button">
      <Prev />
    </button>
    <button class="swiper-button-next swiper-button">
      <Next />
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
  width: 100%;
  height: 100%;
}
.swiper-slide {
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
