<script setup lang="ts">
const phoneNumber = {
  text: '94-29-10',
  img: 'phone',
  link: 'tel:94-29-10',
}
</script>

<template>
  <span class="body">
    <img :src="`/icons/share/${phoneNumber.img}.svg`" :alt="phoneNumber.img">
    <a :href="phoneNumber.link">{{ phoneNumber.text }}</a>
  </span>
</template>

<style scoped lang="scss">
  span {
    display: flex;
    gap: 8px;
    a {
      color: $color-base2;
    }
  }
</style>
