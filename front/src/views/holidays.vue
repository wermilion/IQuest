<script setup lang="ts">
import Cover from '#/components/holidays-view/cover.vue'
import Packages from '#/components/holidays-view/packages/packege-container.vue'
import PackagesCorp from '#/components/holidays-view/packages/package-corp.vue'
import DetailsContainer from '#/components/holidays-view/details/datails-container.vue'

const route = useRoute()
const stores = setupStore(['holiday'])

onMounted(() => {
  stores.holiday.fetchHoliday(`${route.params.id}`)
})

const corp = ref(false)

if (route.params.id === '3')
  corp.value = true
</script>

<template>
  <section v-if="stores.holiday.holiday">
    <Cover :type="stores.holiday.holiday.type" :corp-info="corp" />
    <section v-if="!corp" class="wrapper">
      <Packages />
      <DetailsContainer />
    </section>
    <section v-else class="wrapper">
      <PackagesCorp />
    </section>
  </section>
  <section v-else class="loading">
    <h2>Я не придумал что вставить ;)</h2>
  </section>
</template>

<style scoped lang="scss">
.wrapper {
  display: flex;
  flex-direction: column;
  gap: 108px;
}
</style>
