<script setup lang="ts">
import IconFilled from '#/assets/svg/shared/IconFilled.svg?component'
import IconNoneFilled from '#/assets/svg/shared/IconNoneFilled.svg?component'

defineProps<{ max: number }>()
</script>

<template>
  <span>
    <component
      :is="i > max ? IconNoneFilled : IconFilled"
      v-for="i in 3"
      :key="i"
    />
  </span>
</template>

<style scoped lang="scss">
span {
  display: flex;
  gap: $cover-4;
}
</style>
