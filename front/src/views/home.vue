<script setup lang="ts">
import ViewWrapper from '#/components/layouts/view-wrapper.vue'
import AddServicesVue from '#/components/shared/add-services.vue'
import QuestCardGrid from '#/components/shared/quest-card-grid.vue'
import BanerSwiper from '#/components/stocks-swiper/baner-swiper.vue'

const stores = setupStore(['stocks', 'contact', 'services', 'city', 'global', 'questList'])

const isViewLoading = ref<boolean>(true)

const isLoading = computed(() => (
  !stores.global.isInitialized
  || isViewLoading.value),
)

async function loadView() {
  isViewLoading.value = true
  await Promise.allSettled([
    stores.questList.fetchQuests(),
    stores.contact.fetchContact(),
    stores.services.fetchServices(),
    stores.stocks.fetchStocks(),
  ])
  isViewLoading.value = false
}

watch(() => stores.city.selectedCity, loadView)

loadView()
</script>

<template>
  <ViewWrapper :is-loading="isLoading">
    <section class="bag-black">
      <BanerSwiper />
      <QuestCardGrid />
      <AddServicesVue />
    </section>
  </ViewWrapper>
</template>

<style scoped lang="scss">
.bag-black {
  display: flex;
  flex-direction: column;
  gap: 108px;
}

@media screen and (max-width: 1024px) {
  .bag-black:nth-child(2) {
    margin-top: clamp(40px, 6vw, 108px);
  }
}
</style>
