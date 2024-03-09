<script setup lang="ts">
import {
  YandexMap,
  YandexMapControls,
  YandexMapDefaultSchemeLayer,
  YandexMapZoomControl,
} from 'vue-yandex-maps'
</script>

<template>
  <section>
    <h1>Контакты</h1>
    <YandexMap
      :settings="{
        location: {

          center: [84.947649, 56.484645],
          zoom: 15,
        },
      }"
      height="100vh"
    >
      <YandexMapDefaultSchemeLayer :settings="{ theme: 'dark' }" />
      <YandexMapControls :settings="{ position: 'right' }">
        <YandexMapZoomControl />
      </YandexMapControls>
    </YandexMap>
  </section>
</template>

<style scoped>
#map {
  width: 100%;
  height: 400px;
}
</style>
