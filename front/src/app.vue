<script setup lang="ts">
import { type WritableComputedRef, computed } from 'vue'
import HeaderComponent from '#/components/header-component.vue'
import FooterComponent from '#/components/footer-component.vue'

const store = setupStore('global')

const loading: WritableComputedRef<boolean> = computed({
  get: () => store.loading,
  set: v => store.setLoading(v),
})

const stores = setupStore(['questList', 'services', 'holidaysList'])

stores.questList.fetchQuests()
stores.holidaysList.fetchHolidaysList()
</script>

<template>
  <div class="main-container">
    <template v-if="loading">
      Loading...
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
