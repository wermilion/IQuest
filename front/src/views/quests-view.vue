<script setup lang="ts">
import addServicesVue from "#/components/add-services/add-services.vue";
import QuestCardGrid from "#/components/quest-card-grid/quest-card-grid.vue";
import BanerSwiper from "#/components/baner-swiper/baner-swiper.vue";
</script>

<template>
  <section class="bg-black">
    <BanerSwiper />
    <QuestCardGrid />
    <addServicesVue />
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
