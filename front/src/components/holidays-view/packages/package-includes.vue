<script setup lang="ts">
import AssistChip from '#/components/quest-view/quest/info/assist-chip.vue'

const props = defineProps<{ description?: string }>()

const itemsArray = ref<string[]>([])

function parseHTML(htmlString: string) {
  const parser = new DOMParser()
  const doc = parser.parseFromString(htmlString, 'text/html')
  const listItems = Array.from(doc.querySelectorAll('li'))
  return listItems.map(item => item.textContent || '')
}

function updateData() {
  if (props.description) {
    const description = props.description || ''
    itemsArray.value = parseHTML(description)
  }
}

watch(() => props.description, () => {
  updateData()
})

updateData()
</script>

<template>
  <div class="includes">
    <h3>В пакет включенно</h3>
    <div v-if="itemsArray.length > 0" class="includes__items">
      <AssistChip
        v-for="(item, index) in itemsArray"
        :key="index"
        :name="item"
      />
    </div>
    <div v-else class="loading">
      <h3>loading...</h3>
    </div>
  </div>
</template>

<style scoped lang="scss">
.includes {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: $cover-32;
  align-self: stretch;

  &__items {
    display: flex;
    align-items: flex-start;
    align-content: flex-start;
    gap: $cover-16;
    align-self: stretch;
    flex-wrap: wrap;
  }
}
.loading {
  display: flex;
  align-items: center;
  justify-content: center;

  h3 {
    color: $color-base2;
  }
}
</style>
