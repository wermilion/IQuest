<script setup lang="ts">
import { id } from 'vuetify/locale'
import BookingModal from '../booking-modal.vue'
import PackageIncludes from './package-includes.vue'
import type { Packages } from '#/types/models/holiday'
import FilterChip from '#/components/quest-view/booking/chips/filter-chip.vue'
import Button from '#/components/shared/button.vue'
import ResultModalDialog from '#/components/shared/result-modal.vue'
import type { ResultModal } from '#/types/shared/common'

const stores = setupStore(['holiday'])

const activePackegeId = ref(stores.holiday.getFirstPackegs?.id)

const activePackege = computed(() => {
  return stores.holiday.holiday?.packages
    .find(item => item.id === activePackegeId.value) as Packages
})

const bookingModal = ref(false)
const resultModal = ref(false)
const isSuccessBooking = ref()

const sort = stores.holiday.holiday?.packages.sort((a, b) => a.id - b.id)
function openBookingModal() {
  bookingModal.value = true
}

function openResultModal(isSuccess: ResultModal) {
  isSuccessBooking.value = isSuccess
  resultModal.value = true
}
</script>

<template>
  <section class="container">
    <div class="booking">
      <div class="booking-header">
        <h2>Пакет</h2>
        <div class="filter">
          <FilterChip
            v-for="item in sort"
            :key="item.name"
            :is-selected="activePackegeId === item.id"
            @click="activePackegeId = item.id"
          >
            {{ item.name }}
          </FilterChip>
        </div>
        <PackageIncludes :description="activePackege.description" />
        <div class="booking-footer">
          <Button
            :button-light="true"
            name="Оформить заявку"
            @click="openBookingModal"
          />
          <span class="body">От {{ activePackege.price }}₽</span>
        </div>
      </div>
    </div>
    <BookingModal
      v-model="bookingModal"
      :package="activePackege"
      @submit="openResultModal"
    />
    <ResultModalDialog
      v-model="resultModal"
      :is-success="isSuccessBooking"
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

    div {
      max-width: 309px;
    }
  }
}
</style>
