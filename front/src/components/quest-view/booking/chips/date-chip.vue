<script setup lang="ts">
import { watch } from 'vue'
import VueDatePicker from '@vuepic/vue-datepicker'
import { setupStore } from '#/stores/combine-stores'
import '@vuepic/vue-datepicker/dist/main.css'
import '#/assets/scss/datepicker.scss'

const stores = setupStore(['chip', 'scheduleQuest', 'quest'])

function format(dates: Date[]) {
  return dates.map((date) => {
    const day = String(date.getDate()).padStart(2, '0')
    const month = String(date.getMonth() + 1).padStart(2, '0')

    return `${day}.${month}`
  }).join(' - ')
}

function select() {
  stores.chip.selectChip('Выбрать даты')
}

watch(() => stores.chip.selectedDate, (newValue) => {
  if (newValue.length > 1) {
    stores.scheduleQuest.fetchScheduleQuest({
      quest: stores.quest.quest?.id ?? '',
      between: stores.chip.selectedDate,
    })
  }
})
</script>

<template>
  <VueDatePicker
    v-model="stores.chip.selectedDate" disable-year-select :clearable="false" placeholder="Выбрать даты"
    :auto-apply="true" locale="ru" :enable-time-picker="false" month-name-format="long" dark range week-num-name="We"
    :min-date="new Date()" :max-date="new Date(new Date().setDate(new Date().getDate() + 30))" :format="format"
    @open="select"
  />
</template>

<style scoped lang="scss">
.selected {
  background-color: $color-primary;

  &:hover {
    background-color: $color-primary;
  }
}
</style>
