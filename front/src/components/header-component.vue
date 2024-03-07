<script setup lang="ts">
const links = [
  { name: 'Квесты', link: '/' },
  { name: 'Праздники', link: '' },
  { name: 'Сертификат', link: '/certificates' },
  { name: 'Контакты', link: '/contacts' },
]

const isActive = ref(false)
const isHoverActive = ref(false)
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
          <div class="link" :class="{ selected: $route.path === link.link }">
            <span>[</span>
            {{ link.name }}
            <div v-if="index === 1" class="select">
              <svg
                v-show="!isHoverActive"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M6.00006 10L12.0001 16L18.0001 10"
                  stroke="white"
                  stroke-width="2"
                  stroke-linecap="square"
                  stroke-linejoin="bevel"
                />
              </svg>
              <svg
                v-show="isHoverActive"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M6 16L12 10L18 16"
                  stroke="white"
                  stroke-width="2"
                  stroke-linecap="square"
                  stroke-linejoin="bevel"
                />
              </svg>
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
        <div class="d-flex">
          <svg
            v-show="!isActive"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M6.00006 10L12.0001 16L18.0001 10"
              stroke="white"
              stroke-width="2"
              stroke-linecap="square"
              stroke-linejoin="bevel"
            />
          </svg>
          <svg
            v-show="isActive"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M6 16L12 10L18 16"
              stroke="white"
              stroke-width="2"
              stroke-linecap="square"
              stroke-linejoin="bevel"
            />
          </svg>
        </div>
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

path {
  stroke: $color-opacity06;
}
</style>
