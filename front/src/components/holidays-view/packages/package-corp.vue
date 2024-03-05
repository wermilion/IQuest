<script setup lang="ts">
import Card from '../details/card.vue'
import FilterChip from '#/components/quest-view/booking/chips/filter-chip.vue'
import CorporaivePlots from '#/components/holidays-view/corporative/corporaive-plots.vue'

const filterChip = ['Живой квест', 'Под ключ']

const activePackege = reactive({
  name: filterChip[0],
})

async function select(item: string) {
  activePackege.name = item
}

const detailsLiveQuest = [
  {
    icon: 'maskIcon',
    description: 'Живой квест - это детективная салонная игра, которая моделирует самые невероятные ситуации',
    footnote: true,
  },
  {
    icon: 'barIcon',
    description: 'Игра не требует беспрерывных действий, поэтому в процессе можно выпивать, есть и общаться',
    footnote: true,
  },
  {
    icon: 'teamIcon',
    description: 'В зависимости от сюжета одновременно могут играть от 8 до 30 человек',
    footnote: true,
  },
]

const detailsKeys = [
  {
    icon: 'fluent',
    description: 'Мы готовы воплотить в жизнь любую идею для вашего корпоратива: подвижный, спокойный , тематический и тд.',
    footnote: true,
  },
  {
    icon: 'rishake',
    description: 'Основная ваша задача это прийти к нам, а дальше мы подберем лучший вариант именно для вашей компании и возьмем все организационные моменты на себя.',
    footnote: true,
  },
]
</script>

<template>
  <section class="container">
    <div class="booking">
      <div class="booking-header">
        <h2>Пакет</h2>
        <div class="booking-info">
          <div class="filter">
            <FilterChip
              v-for="item in filterChip"
              :key="item"
              :is-selected="activePackege.name === item"
              @click="select(item)"
            >
              {{ item }}
            </FilterChip>
          </div>
          <div class="booking-details">
            <Card v-for="item in detailsLiveQuest" v-show="activePackege.name === 'Живой квест'" :key="item.icon" :item="item" />
            <Card v-for="item in detailsKeys" v-show="activePackege.name === 'Под ключ'" :key="item.icon" :item="item" />
          </div>
        </div>
      </div>
    </div>
  </section>
  <CorporaivePlots v-show="activePackege.name === 'Живой квест'" />
</template>

<style scoped lang="scss">
.booking {
  margin-top: 56px;
  width: 100%;
  height: 100%;
  gap: $cover-64;

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

  &-info {
    display: flex;
    flex-direction: column;
    gap: $cover-64;
  }

  &-details {
    display: flex;
    align-items: flex-start;
    align-content: flex-start;
    gap: 24px;
  }
}
</style>
