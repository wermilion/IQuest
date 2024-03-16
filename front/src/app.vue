<script setup lang="ts">
import HeaderComponent from '#/components/header-component.vue'
import FooterComponent from '#/components/footer-component.vue'

const stores = setupStore(['global', 'stocks', 'questList', 'holidaysList', 'contact', 'city'])
const isInitialized = ref(false)

Promise.allSettled([
  stores.city.fetchCities(),
])
  .then (() => {
    isInitialized.value = true
  })

const isLoading: WritableComputedRef<boolean> = computed({
  get: () => stores.global.loading || !isInitialized.value,
  set: v => stores.global.setLoading(v),
})

watch(() => stores.city.selectedCity, () => {
  isInitialized.value = false
  Promise.allSettled([
    stores.contact.fetchContact(),
    stores.stocks.fetchStocks(),
    stores.questList.fetchQuests(),
    stores.holidaysList.fetchHolidaysList(),
  ])
    .then (() => {
      isInitialized.value = true
    })
})
</script>

<template>
  <div class="main-container">
    <template v-if="isLoading">
      <section class="loading">
        <h1>Загрузка...</h1>
      </section>
    </template>

    <template v-else>
      <HeaderComponent />
      <router-view class="main" />
      <FooterComponent />
    </template>
  </div>
</template>

<style scoped lang="scss">
.main {
  flex: 1;

  &-container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }
}

.footer {
  margin-top: auto;
}
</style>
