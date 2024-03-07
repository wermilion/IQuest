<script setup lang="ts">
import DropList from './shared/drop-list.vue'
import Arrow from '#/assets/svg/shared/arrow=default.svg'

const stores = setupStore('holidaysList')

const links = [
  { name: 'Квесты', link: '/' },
  { name: 'Праздники', link: '' },
  { name: 'Сертификат', link: '/certificates' },
  { name: 'Контакты', link: '/contacts' },
]

const isActive = ref(false)
</script>

<template>
  <header class="container-header">
    <div class="header">
      <router-link to="/">
        <img src="/logo/logo.svg" alt="logo">
      </router-link>
      <div class="header-links">
        <router-link
          v-for="(link, index) in links"
          :key="link.name"
          :to="link.link"
          class="footnote"
        >
          <div
            class="link"
            :class="{ selected: $route.path === link.link, holiday: index === 1 }"
          >
            <span>[</span>
            {{ link.name }}
            <div v-if="index === 1" class="select">
              <Arrow class="arrow" />
              <DropList class="drop-down" :item="stores.holidaysList" />
            </div>
            <span>]</span>
          </div>
        </router-link>
      </div>
      <div
        class="header-select link footnote"
        :class="{ selected: isActive === true }"
        @click="isActive = !isActive"
      >
        <span>[</span>
        Томск
        <Arrow />
        <span>]</span>
      </div>
    </div>
  </header>
</template>

<style scoped lang="scss">
.header {
  position: absolute;
  max-width: 1440px;
  display: flex;
  padding: 20px 88px;
  width: 100%;
  max-height: 80px;
  justify-content: space-between;
  align-items: center;

  &-links {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 24px;

    a {
      color: $color-opacity06;
      display: flex;
      gap: 8px;
    }
  }

  .selected {
    position: relative;
    color: $color-base2;

    span {
      visibility: visible !important;
    }

    path {
      stroke: $color-base2;
    }

  }

  .link {
    display: flex;
    padding: 8px 0;
    justify-content: center;
    align-items: center;
    gap: 4px;

    span {
      visibility: hidden;
    }

    &:hover span {
      visibility: visible;
    }

    .select {
      display: flex;
    }
  }

  &-select {
    color: $color-opacity06;
    cursor: pointer;
  }
}

.holiday {
  transition: all .1s ease-in-out;
  .drop-down {
    transition: all .3s ease-in-out;
    top: 60px;
    right: 670px;
    position: absolute;
    display: none;
    z-index: 10;
  }

  .arrow {
    transition: all .1s ease-in-out;
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

path {
  stroke: $color-opacity06;
}
</style>
