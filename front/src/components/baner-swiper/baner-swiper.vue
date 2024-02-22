<script setup lang="ts">
import Swiper from "swiper";
import { onMounted, ref } from "vue";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import SliderComponent from "#/components/baner-swiper/slider-component.vue";
import "swiper/css/bundle";
import "#/assets/scss/swiper.scss";

const slider = ref<HTMLElement | null>(null);
const swiperOptions: any = {
  direction: "vertical",
  slidesPerView: 1,
  spaceBetween: 500,
  speed: 850,
  loop: true,
  autoplay: {
    delay: 10000, // Задержка перед сменой слайдов
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
  EffectFade: true,
  effect: "fade",
  modules: [Navigation, Pagination, Autoplay],
};

onMounted(() => {
  if (slider.value) new Swiper(slider.value, swiperOptions);
});
</script>

<template>
  <section class="bg-secondary">
    <div ref="slider" class="swiper-container container">
      <div class="swiper-wrapper">
        <SliderComponent class="swiper-slide" />
        <SliderComponent class="swiper-slide" />
        <SliderComponent class="swiper-slide" />
        <SliderComponent class="swiper-slide" />
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
      <div class="swiper-pagination" />
    </div>
  </section>
</template>

<style scoped lang="scss">
.bg-secondary {
  background-image: url(/gradient/baner-gradient.svg);
  background-repeat: no-repeat;
  background-size: cover;
  background-position: right;
  overflow: hidden;
}

.swiper-button {
  background: none;
  border: none;
  width: 50px;

  &::after {
    display: none;
  }
}

.swiper-container {
  overflow: hidden;
  position: relative;
  max-height: 316px;
}

.swiper-button {
  top: 260px;

  &.swiper-button-prev {
    left: auto;
  }

  &.swiper-button-next {
    left: 22%;
  }
}

.swiper-pagination {
  left: 9%;
  right: auto;
  top: 260px;
  min-width: 192px;
  display: flex;
  gap: $cover-8;
}
</style>
