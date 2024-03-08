<script setup lang="ts">
import { computed } from 'vue'
import BookingButton from './booking-button.vue'
import BookingModal from './modal/booking-modal.vue'
import type { Schedule, TimeSlots } from '#/types/models/schedule'
import ResultModalDialog from '#/components/shared/result-modal.vue'
import type { ResultModal } from '#/types/shared/common'

const props = defineProps<{ dateTimes: Schedule }>()
const { dateTimes } = props

function formatDateAndWeekday(date: Date) {
  const dateOptions: Intl.DateTimeFormatOptions = { month: 'long', day: 'numeric' }
  const weekdayOptions: Intl.DateTimeFormatOptions = { weekday: 'short' }
  const formattedDate = new Intl.DateTimeFormat('ru-RU', dateOptions).format(date)
  const formattedWeekday = new Intl.DateTimeFormat('ru-RU', weekdayOptions).format(date)
  return `${formattedDate}, ${formattedWeekday}`
}

const dayDate = ref<string | null>(null)
const dayItem = ref<TimeSlots>({} as TimeSlots)

const sortedTimeslots = computed(() => {
  const timeslotsCopy = [...dateTimes.timeslots]
  return timeslotsCopy.sort((a, b) => {
    if (a.time < b.time)
      return -1
    if (a.time > b.time)
      return 1
    return 0
  })
})

const bookingModal = ref(false)
const resultModal = ref(false)
const isSuccessBooking = ref()

function openModal(date: Date, item: TimeSlots) {
  if (item.is_active === true) {
    dayDate.value = formatDateAndWeekday(new Date(date))
    dayItem.value = item
    bookingModal.value = true
  }
}

function openResultModal(isSuccess: ResultModal) {
  isSuccessBooking.value = isSuccess
  resultModal.value = true
}
</script>

<template>
  <div class="schedule">
    <h3>{{ formatDateAndWeekday(new Date(dateTimes.date)) }}</h3>
    <div class="schedule-items">
      <BookingButton
        v-for="item in sortedTimeslots" :key="item.id" :price="item.price" :time="item.time"
        :is-active="item.is_active" @click="openModal(dateTimes.date, item)"
      />
    </div>
    <BookingModal
      v-model="bookingModal"
      :item="dayItem"
      :date="dayDate"
      @submit="openResultModal"
    />
    <ResultModalDialog
      v-model="resultModal"
      :is-success="isSuccessBooking"
    />
  </div>
</template>

<style scoped lang="scss">
.schedule {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: $cover-32;

  &-items {
    display: flex;
    gap: $cover-24;
  }
}
</style>
