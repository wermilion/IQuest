<script setup lang="ts">
interface Props {
  name: string
}

defineProps<Props>()
</script>

<template>
  <div class="chip">
    <span class="footnote">{{ name }}</span>
    <slot />
  </div>
</template>

<style scoped lang="scss">
.chip {
  align-items: center;
  display: flex;
  padding: $cover-12 $cover-20;
  justify-content: space-between;
  gap: $cover-16;
  border-radius: 120px;
  border: 1px solid $color-opacity012;
}
</style>
