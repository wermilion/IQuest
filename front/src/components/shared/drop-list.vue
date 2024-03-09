<script setup lang="ts">
import type { Holiday } from '../../types/models/holiday'

defineProps<{ item: Holiday[] }>()
</script>

<template>
  <div class="dorp-list">
    <router-link
      v-for="element in item"
      :key="element.id"
      class="footnote"
      :to="`/holidays/${element.id}`"
    >
      {{ element.type }}
    </router-link>
  </div>
</template>

<style scoped lang="scss">
.dorp-list {
  display: flex;
  padding: $cover-16;
  flex-direction: column;
  border-radius: $cover-12;
  background-color: $color-base1;
  border: 1px solid $color-opacity012;

  a {
    display: flex;
    padding: $cover-12;
    align-items: center;
    transition: all 0.2s ease-out;

    &:hover {
      color: $color-base2;
    }
  }
}
</style>
