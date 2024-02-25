<script setup lang="ts">
import AddServicesVue from '#/components/shared/add-services.vue'
import QuestCardGrid from '#/components/shared/quest-card-grid.vue'
import BanerSwiper from '#/components/stocks-swiper/baner-swiper.vue'
</script>

<template>
  <section class="bg-black">
    <BanerSwiper />
    <QuestCardGrid />
    <AddServicesVue />
  </section>
</template>

<style scoped lang="scss">
.bg-black {
  display: flex;
  flex-direction: column;
  gap: 108px;
}

section:nth-child(3) {
  margin-top: 108px;
}

section:last-child {
  margin-bottom: 108px;
}
</style>
