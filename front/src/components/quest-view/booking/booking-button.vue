<script setup lang="ts">
const props = defineProps<{ price: string, time: string, isActive: boolean }>()

const time = props.time.replace(/:00$/, '')
const price = props.price.replace(/.00$/, '')
</script>

<template>
  <button :class="{ 'selected ': !isActive, 'pointer': isActive }" class="booking ">
    <span class="body">{{ time }}</span>
    <span class="footnote">{{ price }}₽</span>
  </button>
</template>

<style scoped lang="scss">
button {
  border: 0;
  background-color: none;
}

.booking {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: $cover-16 $cover-32;
  gap: $cover-12;
  background-color: $color-opacity004;
  border-radius: $cover-16;

  &:hover {
    background-color: $color-opacity012;
  }
}

.selected {
  background-color: $color-opacity004;
  opacity: 0.5;
}
</style>
