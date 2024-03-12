<script setup lang="ts">
import DropList from './cities-list.vue'
import Arrow from '#/assets/svg/shared/arrow=default.svg?component'

const stores = setupStore(['city'])
</script>

<template>
  <div
    class="link footnote city pointer"
  >
    <span>[</span>
    {{ stores.city.selectedCity.name }}
    <Arrow class="arrow" />
    <DropList class="drop-down" :item="stores.city.cities!" />
    <span>]</span>
  </div>
</template>

<style scoped lang="scss">
.city {
  position: relative;
  transition: all 0.1s ease-in-out;

  span {
    visibility: hidden;
  }
  .drop-down {
    transition: all 0.3s ease-in-out;
    top: 40px;
    position: absolute;
    display: none;
    z-index: 10;
  }
  .arrow {
    transition: all 0.1s ease-in-out;
    transform: rotate(0);

    :deep(path) {
      stroke-opacity: 0.6;
    }
  }

  &:hover {
    color: $color-base2;
    .arrow {
      transform: rotate(180deg);
      :deep(path) {
        stroke-opacity: 1;
      }
    }
    span {
      visibility: visible;
      color: $color-base2;
    }
    .drop-down {
      display: block;
    }
  }
}
</style>
