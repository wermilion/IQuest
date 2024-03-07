<script setup lang="ts">
interface Props {
  isSelected: boolean
}

defineProps<Props>()
</script>

<template>
  <div class="chip pointer" :class="{ isSelected }">
    <span class="body">
      <slot />
    </span>
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
