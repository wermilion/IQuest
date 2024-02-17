<script setup lang="ts">
import Swiper from "swiper";
import SliderComponent from "#/components/baner-swiper/slider-component.vue";
import { ref, onMounted } from "vue";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import "swiper/css/bundle";

const slider = ref<HTMLElement | null>(null);
const swiiperOptions: any = {
  direction: "vertical",
  slidersPerView: 1,
  sliderPerGroup: 1,
  speed: 850,
  loop: true,
  autoplay: {
    delay: 10000,
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  modules: [Navigation, Pagination, Autoplay],
};

onMounted(() => {
  if (slider.value) {
    new Swiper(slider.value as HTMLElement, swiiperOptions);
  }
});
</script>

<template>
  <section class="bg-secondary">
    <div ref="slider" class="swiper-container container">
      <div class="swiper-wrapper">
        <slider-component class="swiper-slide" />
        <slider-component class="swiper-slide" />
        <slider-component class="swiper-slide" />
      </div>

      <button class="swiper-button-prev swiper-button">
        <svg
          width="40"
          height="40"
          viewBox="0 0 40 40"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M16 28L8 20L16 12"
            stroke="white"
            stroke-opacity="0.75"
            stroke-width="2"
            stroke-linecap="square"
            stroke-linejoin="round"
          />
        </svg>
      </button>
      <button class="swiper-button-next swiper-button">
        <svg
          width="40"
          height="40"
          viewBox="0 0 40 40"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M24 12L32 20L24 28"
            stroke="white"
            stroke-opacity="0.75"
            stroke-width="2"
            stroke-linecap="square"
            stroke-linejoin="round"
          />
        </svg>
      </button>
      <div class="swiper-pagination"></div>
    </div>
  </section>
</template>

<style scoped lang="scss">
.bg-secondary {
  background-image: url(/gradient/baner-gradient.svg);
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  overflow: hidden;
  height: 316px;
}

.swiper-button {
  background: none;
  border: none;
  width: 44px;

  &::after {
    display: none;
  }
}

.swiper-container {
  overflow: hidden;
}

.swiper-pagination {
  right: auto;
  min-width: 192px;
  display: flex;
  gap: $cover-8;
}
</style>
