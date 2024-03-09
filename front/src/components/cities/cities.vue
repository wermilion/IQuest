<script setup lang="ts">
import DropList from './cities-list.vue'
import Arrow from '#/assets/svg/shared/arrow=default.svg?component'

const stores = setupStore(['city'])
</script>

<template>
  <div
    class="link footnote city"
  >
    <span>[</span>
    {{ stores.city.city?.[0].name }}
    <Arrow class="arrow" />
    <DropList class="drop-down" :item="stores.city.city!" />
    <span>]</span>
  </div>
</template>

<style scoped lang="scss">
.city {
  transition: all 0.1s ease-in-out;
  .drop-down {
    transition: all 0.3s ease-in-out;
    top: 60px;
    right: 65px;
    position: absolute;
    display: none;
    z-index: 10;
  }

  .arrow {
    transition: all 0.1s ease-in-out;
    transform: rotate(0);
  }

  &:hover {
    color: $color-base2;
    .arrow {
      transform: rotate(180deg);
    }
    span {
      color: $color-base2;
    }
    .drop-down {
      display: block;
    }
  }
}
</style>
