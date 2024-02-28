<script setup lang="ts">
import { onMounted } from 'vue'
import FilterChip from './chips/filter-chip.vue'
import DateChip from './chips/date-chip.vue'
import ScheduleContainer from './schedule-container.vue'
import { setupStore } from '#/stores/combine-stores'
import type { SearchScheduleQuestsRequest } from '#/utils/api/services/quest/quest.types'

const props = defineProps<{ idQuest: number }>()

const filters = [
  {
    name: 'Сегодня',
  },
  {
    name: 'Завтра',
  },
  {
    name: 'Эти выходные',
  },
  {
    name: 'Выбрать даты',
    slot: {
      is: DateChip,
    },
  },
]

const stores = setupStore(['scheduleQuest', 'chip'])

async function select(chip: string) {
  const filter = { quest: props.idQuest } as SearchScheduleQuestsRequest['filter']

  if (stores.chip.selectedChip !== chip)
    stores.chip.$patch({ selectedDate: [] })

  stores.chip.selectChip(chip)

  switch (stores.chip.selectedChip) {
    case 'Сегодня':
      filter.today = true
      break
    case 'Завтра':
      filter.tomorrow = true
      break
    case 'Эти выходные':
      filter.weekend = true
      break
  }

  await stores.scheduleQuest.fetchScheduleQuest(filter)
}

onMounted(() => {
  select(filters[0].name)
})
</script>

<template>
  <section class="container">
    <div class="booking">
      <div class="booking-header">
        <h2>Расписание</h2>
        <div class="filter">
          <FilterChip v-for="item in filters" :id="idQuest" :key="item.name" :chip="item" @click="select(item.name)">
            <component :is="item.slot?.is" />
          </FilterChip>
        </div>
        <div class="booking-schedule">
          <ScheduleContainer v-for="item in stores.scheduleQuest.scheduleQuest" :key="item.id" :date-times="item" />
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
}
</style>
