<script setup lang="ts">
import Cover from '#/components/holidays-view/cover.vue'
import Packages from '#/components/holidays-view/packages/packege-container.vue'
import DetailsContainer from '#/components/holidays-view/details/datails-container.vue'

const route = useRoute()
const stores = setupStore(['holiday'])

const itemsArray = ref<string[]>([])

// Функция для парсинга HTML и извлечения данных
function parseHTML(htmlString: string) {
  const parser = new DOMParser()
  const doc = parser.parseFromString(htmlString, 'text/html')
  const listItems = Array.from(doc.querySelectorAll('li'))
  return listItems.map(item => item.textContent || '')
}

// Ждем, пока загрузится компонент
onMounted(() => {
  // Получаем данные о праздниках
  stores.holiday.fetchHoliday(`${route.params.id}`).then(() => {
    // Получаем описание пакета
    const description = stores.holiday.holiday?.packages[0].description || ''
    // Парсим HTML и сохраняем результат в массив
    itemsArray.value = parseHTML(description)
  })
})
</script>

<template>
  <section v-if="stores.holiday.holiday" class="wrapper">
    <Cover :type="stores.holiday.holiday.type" />
    <Packages />
    <DetailsContainer />
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
