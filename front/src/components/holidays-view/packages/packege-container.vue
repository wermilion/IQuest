<script setup lang="ts">
import PackageIncludes from './package-includes.vue'
import FilterChip from '#/components/quest-view/booking/chips/filter-chip.vue'
import Button from '#/components/shared/button.vue'

const stores = setupStore(['holiday'])

const defaultChip = stores.holiday.holiday?.packages[0]?.name
const defaultDesc = stores.holiday.holiday?.packages[0]?.description
const defaultPrice = stores.holiday.holiday?.packages[0]?.price

const selectedChip = ref(defaultChip)
const selectedDesc = ref(defaultDesc)
const selectedPrice = ref(defaultPrice)

async function select(name: string, description: string, price: number) {
  selectedChip.value = name
  selectedDesc.value = description
  selectedPrice.value = price
}
</script>

<template>
  <section class="container">
    <div class="booking">
      <div class="booking-header">
        <h2>Пакет</h2>
        <div class="filter">
          <FilterChip
            v-for="item in stores.holiday.holiday?.packages"
            :key="item.name"
            :is-selected="selectedChip === item.name"
            @click="select(item.name, item.description, item.price)"
          >
            {{ item.name }}
          </FilterChip>
        </div>
        <PackageIncludes :description="selectedDesc" />
        <div class="booking-footer">
          <Button :button-light="true" name="Забронировать" />
          <span class="body">От {{ selectedPrice?.toString().replace(/.00$/, '') }}₽</span>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">
.booking {
  width: 100%;
  height: 100%;
  gap: $cover-64;
  border-radius: $cover-16;
  padding: $cover-48;
  background-color: $color-opacity004;

  &-header {
    display: flex;
    flex-direction: column;
    gap: $cover-32;

    h2 {
      color: $color-opacity06;
    }

    .filter {
      display: flex;
      flex-wrap: wrap;
      gap: $cover-16;
    }
  }

  &-schedule {
    display: flex;
    flex-direction: column;
    gap: $cover-64;
  }

  &-footer {
    align-items: center;
    display: flex;
    gap: $cover-24;

    a {
      max-width: 308px;
    }
  }
}
</style>
