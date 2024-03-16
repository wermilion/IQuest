<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  address?: string
}

const props = defineProps<Props>()

const img = 'pin'

const yandexMapUrl = computed(() => `https://yandex.ru/maps/?text=${props.address}`)
</script>

<template>
  <span class="body">
    <img :src="`/icons/share/${img}.svg`" :alt="img">
    <a :href="yandexMapUrl" target="_blank">{{ address }}</a>
  </span>
</template>

<style scoped lang="scss">
  span {
  display: flex;
  gap: 8px;
  align-items: center;
  a {
    color: $color-base2;
  }

  img {
    width: clamp(22px, 5vw, $cover-28);
  }
}
</style>
