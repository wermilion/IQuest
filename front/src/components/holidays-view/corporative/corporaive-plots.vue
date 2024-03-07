<script setup lang="ts">
import PlotCard from './plot-card.vue'

import TitlePlots from '#/assets/svg/shared/titlePlots.svg?component'
import PlotList from '#/utils/mock/plot-list'
</script>

<template>
  <div class="container">
    <div class="title">
      <TitlePlots />
      <img src="/gradient/gradient.png" alt="gradient">
    </div>
    <div class="plots-list">
      <PlotCard v-for="plot in PlotList" :key="plot.name" :info="plot" />
    </div>
  </div>
</template>

<style scoped lang="scss">
.container {
  position: relative;
  display: flex;
  flex-direction: column;
  gap: 108px;
}
.title {
  position: absolute;
  height: 600px;
  svg {
    top: 0px;
    position: sticky;
  }

  img {
    position: relative;
  }
}

.plots-list {
  margin-top: 290px;
  display: flex;
  flex-direction: column;
  gap: 108px;
}
</style>
