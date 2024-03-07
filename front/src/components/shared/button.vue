<script setup lang="ts">
interface Button {
  name: string
  buttonLight?: boolean
}

defineProps<Button>()
</script>

<template>
  <router-link
    class="btn-container button"
    :class="{ buttonLight }"
    to=""
  >
    <span class="bodyBold">{{ name }}</span>
  </router-link>
</template>

<style scoped lang="scss">
.button {
  justify-content: center;
  border-radius: $cover-16;
  transition: $hover-anim-btn;
  background-color: $color-opacity004;

  &:hover {
    background-color: $color-opacity012;
  }
}

.buttonLight {
  background-color: $color-primary;

  &:hover {
    background-color: $color-light-primary;
  }
}
</style>
