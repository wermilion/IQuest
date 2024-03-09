<script setup lang="ts">
import Button from '../shared/button.vue'
import RoomsFilter from './rooms-filter.vue'
import BookingModal from './booking-modal.vue'
import Back from '#/components/shared/back.vue'
import FilterChip from '#/components/quest-view/booking/chips/filter-chip.vue'
import type { ResultModal } from '#/types/shared/common'
import People from '#/assets/svg/shared/people.svg?component'
import Price from '#/assets/svg/shared/cash.svg?component'
import ResultModalDialog from '#/components/shared/result-modal.vue'

const stores = setupStore(['filialList'])

const activeFilialId = ref(stores.filialList.getFirstFilial?.id)
const activeRoomId = ref(stores.filialList.getFirstRoom?.id)

watch(activeFilialId, (newFilialId) => {
  const newRoomId = stores.filialList.filialList
    .find(({ id }) => id === newFilialId)?.lounges[0]?.id
  if (newRoomId)
    activeRoomId.value = newRoomId
})

const activeFilial = computed(() => {
  return stores.filialList.filialList
    .find(({ id }) => id === activeFilialId.value)
})

const activeRoom = computed(() => {
  if (!activeFilial.value)
    return null
  return activeFilial.value.lounges
    .find(({ id }) => id === activeRoomId.value)
})

const bookingModal = ref(false)
const resultModal = ref(false)
const isSuccessBooking = ref()

function openBookingModal() {
  bookingModal.value = true
}

function openResultModal(isSuccess: ResultModal) {
  isSuccessBooking.value = isSuccess
  resultModal.value = true
}
</script>

<template>
  <div class="block">
    <Back />
    <div class="block-container">
      <div class="img-container">
        <img :key="activeRoom?.cover" v-lazy-src="activeRoom?.cover" class="loading-lazy" alt="">
      </div>
      <div class="wrapper">
        <div class="wrapper-header">
          <h1>Лаунж зона</h1>
          <div class="filter">
            <FilterChip
              v-for="item in stores.filialList.filialList"
              :key="item.city.name"
              :is-selected="activeFilialId === item.id"
              @click="activeFilialId = item.id"
            >
              {{ item.city.name }}
            </FilterChip>
          </div>
          <div class="wrapper-header__rooms">
            <span class="bodyBold">Комната:</span>
            <div class="filter">
              <RoomsFilter
                v-for="element in activeFilial?.lounges"
                :key="element.name"
                :is-selected="activeRoomId === element.id"
                @click="activeRoomId = element.id"
              >
                {{ element.name }}
              </RoomsFilter>
            </div>
          </div>
        </div>
        <div class="wrapper-content">
          <div class="wrapper-content__text">
            <span class="bodyBold">Описание</span>
            <p class="footnoteText" v-html="activeRoom?.description" />
          </div>
          <div class="wrapper-content__people">
            <People />
            <span class="footnote">до {{ activeRoom?.max_people }} человек</span>
          </div>
        </div>
        <div class="wrapper-footer">
          <div class="wrapper-footer__price">
            <Price />
            <span class="footnote">
              {{ activeRoom?.price_per_half_hour }}₽/30 мин •
              {{ activeRoom?.price_per_hour }}₽/60 мин
            </span>
          </div>
          <Button :button-light="true" name="Оформить заявку" @click="openBookingModal" />
        </div>
      </div>
      <BookingModal
        v-model="bookingModal"
        :lounge="activeRoom!"
        @submit="openResultModal"
      />
      <ResultModalDialog
        v-model="resultModal"
        :is-success="isSuccessBooking"
      />
    </div>
  </div>
</template>

<style scoped lang="scss">
.block {
  display: flex;
  flex-direction: column;
  gap: $cover-12;
  width: 100%;

  &-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    width: 100%;
  }
}
.img-container {
  overflow: hidden;
  border-radius: $cover-12;
  width: 600px;
  height: 568px;

  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
}

.filter {
  display: flex;
  align-items: center;
  align-content: center;
  gap: $cover-16;
  flex-wrap: wrap;
}

.wrapper {
  width: 100%;
  max-width: 600px;
  display: flex;
  flex-direction: column;
  gap: $cover-64;
  align-items: flex-start;

  &-header {
    display: flex;
    flex-direction: column;
    gap: $cover-32;

    &__rooms {
      display: flex;
      flex-direction: column;
      gap: $cover-8;
    }
  }

  &-content {
    display: flex;
    flex-direction: column;
    gap: $cover-24;

    &__text {
      display: flex;
      flex-direction: column;
      gap: $cover-12;
    }

    &__people {
      display: flex;
      gap: $cover-12;
      align-items: center;
    }
  }

  &-footer {
    width: 100%;
    display: flex;
    flex-direction: column;
    padding: $cover-24;
    gap: $cover-24;
    border-radius: $cover-12;
    background-color: $color-opacity004;

    &__price {
      display: flex;
      align-items: center;
      gap: $cover-16;
    }
  }
}
</style>
