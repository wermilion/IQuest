<script setup lang="ts">
import {
  YandexMap,
  YandexMapControls,
  YandexMapDefaultFeaturesLayer,
  YandexMapDefaultMarker,
  YandexMapDefaultSchemeLayer,
  YandexMapZoomControl,
} from 'vue-yandex-maps'
import type { LngLat } from '@yandex/ymaps3-types'

const store = setupStore('filialList')

const active = ref(store.getFirstFilial.id)

const center = ref([store.getFirstFilial.longitude, store.getFirstFilial.width] as LngLat)

function mapToMove(lon: number, lag: number, id: number) {
  center.value = [lon, lag] as LngLat
  active.value = id
}
</script>

<template>
  <div class="map">
    <div class="map-button">
      <span
        v-for="item in store.filialList"
        :key="item.id"
        class="bodyBold pointer"
        :class="{ active: active === item.id }"
        @click="mapToMove(item.longitude, item.width, item.id)"
      >
        {{ item.address }}
      </span>
    </div>
    <div class="map-container">
      <YandexMap
        :settings="{
          location: {
            center,
            zoom: 16,
          },
          zoomRange: {
            min: 16,
            max: 20,
          },
        }"
        theme
        height="492px"
        showScaleInCopyrights: true
        width="100%"
      >
        <YandexMapDefaultSchemeLayer :settings="{ theme: 'dark' }" />
        <YandexMapDefaultFeaturesLayer />
        <YandexMapControls :settings="{ position: 'right' }">
          <YandexMapZoomControl />
        </YandexMapControls>
        <YandexMapDefaultMarker
          v-for="marker in store.filialList"
          :key="marker.id"
          :settings="{
            coordinates: [marker.longitude, marker.width],
            title: marker.address,
            color: 'balck',
          }"
        />
      </YandexMap>
    </div>
  </div>
</template>

<style scoped lang="scss">
.bodyBold {
  color: $color-opacity06;
}
.map {
  display: flex;
  flex-direction: column;
  gap: $cover-32;

  &-button {
    display: flex;
    gap: $cover-32;
  }

  &-container {
    border-radius: $cover-12;
    overflow: hidden;
  }
}

.active {
  color: $color-base2;
}
</style>
