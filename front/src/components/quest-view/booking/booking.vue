<script setup lang="ts">
import FilterChip from './filter-chip.vue'

const filters = ['Сегодня', 'Завтра', 'Эти выходные', 'Выбрать даты']
</script>

<template>
  <section class="container">
    <div class="booking">
      <div class="booking-header">
        <h2>Расписание</h2>
        <div class="filter">
          <FilterChip v-for="item in filters" :key="item" :chip="item" />
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
      color:$color-opacity06;
    }

    .filter {
      display: flex;
      gap: $cover-16;
    }
  }
}
</style>
