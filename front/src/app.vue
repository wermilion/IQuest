<script setup lang="ts">
import { type WritableComputedRef, computed } from 'vue'
import HeaderComponent from '#/components/header-component.vue'
import FooterComponent from '#/components/footer-component.vue'
import { useGlobalStore } from '#/stores/common/global.store'

const store = useGlobalStore()

const loading: WritableComputedRef<boolean> = computed({
  get: () => store.loading,
  set: v => store.setLoading(v),
})
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
