<script setup lang="ts">
import Cover from '#/components/holidays-view/cover.vue'
import PackagesMain from '#/components/holidays-view/packages/packege-container.vue'
import PackagesCorp from '#/components/holidays-view/packages/package-corp.vue'

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
    <section v-if="!corp">
      <PackagesMain :key="stores.holiday.getFirstPackegs?.id" />
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
  gap: clamp($cover-64, 20vw, 108px);
}
</style>
