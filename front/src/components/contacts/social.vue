<script setup lang="ts">
defineProps<{ isActiveImg?: boolean }>()

const store = setupStore('contact')
</script>

<template>
  <div class="social-list">
    <a
      v-for="item in store.getSocial"
      :key="item.id"
      class="body"
      :href="item.value"
      target="_blank"
    >
      {{ item.type.name }}
    </a>
  </div>
</template>

<style scoped lang="scss">
.social-list {
  display: flex;
  gap: $cover-32;
  flex-wrap: wrap;
}
a {
  color: $color-opacity06;
  text-decoration-line: underline;
  transition: $hover-animation;

  &:hover {
    color: $color-base2;
  }
}
</style>
