<script setup lang="ts">
import Lounge from '#/components/lounge/lounge-main.vue'

const store = setupStore('filialList')

onMounted(() => {
  store.fetchFilial()
})
</script>

<template>
  <section v-if="store.getFirstFilial" class="container">
    <Lounge />
  </section>
  <template v-else>
    <section class="loading">
      <h1>Загрузка лаунжей</h1>
    </section>
  </template>
</template>

<style scoped lang="scss">
.container {
  margin-top: 112px;
}
</style>
