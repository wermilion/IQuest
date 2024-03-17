<script setup lang="ts">
import { LottieAnimation } from 'lottie-web-vue'
import WatermelonJSON from '#/assets/animation/animate.json'
</script>

<template>
  <LottieAnimation
    class="loading"
    :animation-data="WatermelonJSON"
    :loop="true"
    :auto-play="true"
    :speed="1"
  />
</template>
