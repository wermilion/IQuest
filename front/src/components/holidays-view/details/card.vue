<script setup lang="ts">
export interface Props {
  icon: string
  description: string
}

defineProps<{ item: Props }>()
</script>

<template>
  <div class="item">
    <img :src="`/icons/details/${item.icon}.svg`" :alt="item.icon">
    <p class="smallFootnote">
      {{ item.description }}
    </p>
  </div>
</template>

<style scoped lang="scss">
.item {
  display: flex;
  height: 100%;
  min-height: 280px;
  width: 100%;
  padding: $cover-32;
  flex-direction: column;
  align-items: flex-start;
  gap: $cover-10;
  border-radius: $cover-8;
  border: 1px solid $color-opacity012;

  p {
    color: $color-base2;
  }
}
</style>
