<script setup lang="ts">
import AddServicesVue from '#/components/shared/add-services.vue'
import QuestCardGrid from '#/components/shared/quest-card-grid.vue'
import BanerSwiper from '#/components/stocks-swiper/baner-swiper.vue'

const stores = setupStore(['stocks', 'questList'])

onMounted(() => {
  stores.stocks.fetchStocks()
  stores.questList.fetchQuests()
})
</script>

<template>
  <section v-if="stores.stocks.stocks" class="bg-black">
    <BanerSwiper />
    <QuestCardGrid />
    <AddServicesVue />
  </section>
  <section v-else class="loading">
    <h2>Я не придумал что вставить ;)</h2>
  </section>
</template>

<style scoped lang="scss">
.loading {
  display: flex;
  align-items: center;
  justify-content: center;
}

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
