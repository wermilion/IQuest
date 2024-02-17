<template>
  <section ref="slider" class="swiper-container">
    <div class="swiper-wrapper">
      <div class="swiper-slide"><h1>1</h1></div>
      <div class="swiper-slide"><h1>1</h1></div>
      <div class="swiper-slide"><h1>1</h1></div>
    </div>
    <button class="swiper-button-prev swiper-button"></button>
    <button class="swiper-button-next swiper-button"></button>
    <div class="swiper-pagination"></div>
  </section>
</template>

<script setup lang="ts">
import Swiper from "swiper";
import { ref, onMounted } from "vue";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import "swiper/css/bundle";

const slider = ref<HTMLElement | null>(null);
const swiiperOptions: any = {
  slidersPerView: 1,
  sliderPerGroup: 1,
  speed: 800,
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

<style></style>
