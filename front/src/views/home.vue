<script setup lang="ts">
import AddServicesVue from '#/components/shared/add-services.vue'
import QuestCardGrid from '#/components/shared/quest-card-grid.vue'
import BanerSwiper from '#/components/stocks-swiper/baner-swiper.vue'

const stores = setupStore(['stocks', 'services'])

stores.services.fetchServices()
</script>

<template>
  <section v-if="stores.stocks.stocks" class="bag-black">
    <BanerSwiper />
    <QuestCardGrid />
    <AddServicesVue />
  </section>
  <section v-else class="loading">
    <h2>Я не придумал что вставить ;)</h2>
  </section>
</template>

<style scoped lang="scss">
.bag-black {
  display: flex;
  flex-direction: column;
  gap: 108px;

  &:nth-child(3) {
    margin-top: 108px;
  }
}

@media screen and (max-width: 1024px) {
  .bag-black:nth-child(2) {
    margin-top: clamp(40px, 6vw, 108px);
  }
}
</style>
