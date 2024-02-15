<script setup lang="ts">
import { ref } from "vue";

const links = ref([
  {
    name: "Квесты",
    link: "/home",
  },
  {
    name: "Праздники",
    link: "#",
  },
  {
    name: "Сертификат",
    link: "/",
  },
  {
    name: "Контакты",
    link: "/",
  },
]);

let isActive = ref(false);
let isHoverActive = ref(false);
</script>

<template>
  <div class="header container">
    <img src="/logo/logo.svg" alt="logo" />
    <div class="header-links">
      <router-link
        v-for="(link, index) in links"
        :to="link.link"
        class="footnote"
      >
        <div class="link" :class="{ selected: $route.path === link.link }">
          <span>[</span> {{ link.name }}
          <div class="select" v-if="index == 1">
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
    <div @click="isActive = !isActive" class="header-select">
      <p class="footnote">Томск</p>
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
    </div>
  </div>
</template>

<style scoped lang="scss">
.header {
  padding: 20px 88px;
  width: 100%;
  max-height: 88px;
  justify-content: space-between;
  align-items: center;

  &-links {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 24px;

    a {
      color: $color-opacity075;
      display: flex;
      gap: 8px;
    }
  }

  .selected {
    color: $color-base2;

    span {
      visibility: visible !important;
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
      path {
        stroke: $color-opacity075;
      }
    }
  }

  &-select {
    display: flex;
    padding: 8px 0px;
    justify-content: center;
    align-items: center;
    gap: 2px;
    cursor: pointer;

    p {
      color: $color-base2;
    }
  }
}
</style>
