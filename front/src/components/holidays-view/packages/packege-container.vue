<script setup lang="ts">
import BookingModal from '../booking-modal.vue'
import type { Packages } from '../../../types/models/holiday'
import PackageIncludes from './package-includes.vue'
import FilterChip from '#/components/quest-view/booking/chips/filter-chip.vue'
import Button from '#/components/shared/button.vue'

const stores = setupStore(['holiday'])

const defaultPackage = computed(() => stores.holiday.holiday?.packages[0])

const activePackege = reactive({
  name: ref(defaultPackage.value?.name || ''),
  description: ref(defaultPackage.value?.description || ''),
  price: ref(defaultPackage.value?.price || ''),
  id: ref(defaultPackage.value?.id || 0),
  sequence_number: ref(defaultPackage.value?.sequence_number || 0),
})

async function select(item: Packages) {
  activePackege.name = item.name
  activePackege.description = item.description
  activePackege.price = item.price
  activePackege.id = item.id
  activePackege.sequence_number = item.sequence_number
}

const modal = ref(false)

function openModal() {
  modal.value = true
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
            :is-selected="activePackege.name === item.name"
            @click="select(item)"
          >
            {{ item.name }}
          </FilterChip>
        </div>
        <PackageIncludes :description="activePackege.description" />
        <div class="booking-footer">
          <Button :button-light="true" name="Забронировать" @click="openModal()" />
          <span class="body">От {{ activePackege.price?.toString().replace(/.00$/, '') }}₽</span>
        </div>
      </div>
    </div>
    <BookingModal
      v-model="modal"
      :package="activePackege"
    />
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
