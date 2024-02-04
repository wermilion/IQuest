<script setup lang="ts">
import { type WritableComputedRef, computed } from "vue";
import HeaderComponent from "#/components/header/header-component.vue";
import FooterComponent from "#/components/footer/footer-component.vue";
import { useGlobalStore } from "#/stores/common/global.store";

const store = useGlobalStore();

const loading: WritableComputedRef<boolean> = computed({
  get: () => store.loading,
  set: (v) => store.setLoading(v),
});
</script>

<template>
  <template v-if="loading"> Loading... </template>

  <template v-else>
    <HeaderComponent />
    <router-view />
    <FooterComponent />
  </template>
</template>
