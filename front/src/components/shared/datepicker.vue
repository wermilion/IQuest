<script setup lang="ts">
import VueDatePicker from '@vuepic/vue-datepicker'

const emit = defineEmits<{ select: [value: string[] ] }>()
const selectedDate = ref<string[]>()

function format(dates: Date[]) {
  return dates.map((date) => {
    const day = String(date.getDate()).padStart(2, '0')
    const month = String(date.getMonth() + 1).padStart(2, '0')

    return `${day}.${month}`
  }).join(' - ')
}

watch(selectedDate, (value) => {
  if (value && value.length > 1)
    emit?.('select', value)
})
</script>

<template>
  <VueDatePicker
    v-model="selectedDate"
    disable-year-select
    :clearable="false"
    placeholder="Выбрать даты"
    :auto-apply="true"
    locale="ru"
    :enable-time-picker="false"
    month-name-format="long"
    dark range week-num-name="We"
    :min-date="new Date()"
    :max-date="new Date(new Date().setDate(new Date().getDate() + 30))"
    :format="format"
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
