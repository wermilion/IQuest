<script setup lang="ts">
import { useRouter } from 'vue-router'
import { EAppRouteNames } from '../types/routes'
import ViewWrapper from '#/components/layouts/view-wrapper.vue'
import Error from '#/assets/svg/error/error.svg?component'
import Button from '#/components/shared/button.vue'

const router = useRouter()
const stores = setupStore(['global'])
// const isViewLoading = ref<boolean>(true)

const isLoading = computed(() => {
  return !stores.global.isInitialized
})

function goToQuest() {
  router.push({ name: EAppRouteNames.Home })
}

function goBack() {
  router.go(-1)
}
</script>

<template>
  <ViewWrapper :is-loading="isLoading">
    <div class="error">
      <div class="error-header">
        <Error />
        <h3>Страница не найдена</h3>
      </div>
      <div class="error-content">
        <Button :button-light="true" name="Смотреть квесты" @click="goToQuest" />
        <Button :button-light="false" name="Назад" @click="goBack" />
      </div>
    </div>
  </ViewWrapper>
</template>

<style scoped lang="scss">
.error {
  margin: 0 auto;
  max-width: 566px;
  max-height: 378px;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  gap: $cover-48;

  &-header {
    align-items: center;
    display: flex;
    flex-direction: column;
    gap: $cover-16;

    :deep(svg) {
      overflow: visible;
      padding-left: 72px;
    }
  }

  &-content {
    display: flex;
    gap: $cover-24;

    @media (max-width: 600px) {
      flex-wrap: wrap;
    }
  }
}
</style>
