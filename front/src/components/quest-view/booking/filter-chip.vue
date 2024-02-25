<script setup lang="ts">
import { computed } from 'vue'
import { useChipStore } from '#/stores/common/booking.store'

const props = defineProps<{ chip: string }>()

const chipStore = useChipStore()

const isSelected = computed(() => chipStore.selectedChip === props.chip)
function select() {
  chipStore.selectChip(props.chip)
}
</script>

<template>
  <div class="chip pointer" :class="{ selected: isSelected }" @click="select">
    <span class="body">{{ chip }}</span>
  </div>
</template>

<style scoped lang="scss">
.chip {
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 120px;
  background-color: $color-opacity004;
  padding: $cover-16 $cover-24;

  &:hover {
    background-color: $color-opacity012;
  }
}

.selected {
  background-color: $color-primary;

  &:hover {
    background-color: $color-primary;
  }
}
</style>
