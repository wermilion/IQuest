<script setup lang="ts">
import Link from '#/assets/svg/shared/link-quest.svg?url'

interface Props {
  address?: string
  isActiveImg?: boolean
  isActiveLink?: boolean
}

const props = defineProps<Props>()

const img = 'pin'

const yandexMapUrl = computed(() => `https://yandex.ru/maps/?text=${props.address}`)
</script>

<template>
  <a :href="yandexMapUrl" target="_blank" class="body" :class="{ isActiveLink }">
    <img v-if="!isActiveImg" :src="`/icons/share/${img}.svg`" :alt="img">
    <span>{{ address }} </span>
    <img v-if="isActiveLink" :src="Link">
  </a>
</template>

<style scoped lang="scss">
  a {
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

@media screen and (max-width: 600px) {
  .isActiveLink {
    display: flex;
    padding: $cover-16 $cover-24;
    justify-content: space-between;
    align-items: center;
    border-radius: $cover-16;
    background: $color-opacity004;
  }
}
</style>
