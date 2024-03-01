<script setup lang="ts">
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps<{
  chip: {
    name: string
  }
  id: number
}>()
const stores = setupStore(['chip', 'scheduleQuest'])

const isSelected = computed(() => stores.chip.selectedChip === props.chip.name)
</script>

<template>
  <div class="chip pointer" :class="{ isSelected }">
    <span v-if="chip.name !== 'Выбрать даты'" class="body">{{ chip.name }}</span>
    <slot />
  </div>
</template>

<style scoped lang="scss">
.chip {
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 120px;
  background-color: $color-opacity004;
  padding: $cover-16 $cover-48;

  &:hover {
    background-color: $color-opacity012;
  }
}

.isSelected {
  background-color: $color-primary;

  &:hover {
    background-color: $color-primary;
  }
}
</style>
