<script setup lang="ts">
import Card from './card.vue'
import PhoneNumber from '#/components/shared/phone-number.vue'

const details = [
  {
    icon: 'peopleIcon',
    description: 'Если игроков больше 6, за каждого дополнительного игрока будет доплата',
  },
  {
    icon: 'calendarIcon',
    description: 'Минимальный срок заказа - за 4 дня до мероприятия. В случае, если заявка поступает менее чем за 4 дня, вопрос решается в индивидуальном порядке',
  },
  {
    icon: 'prepaymentIcon',
    description: 'Требуется предоплата минимум за 4 дня до даты праздника. При отмене предоплата не возвращается',
  },
  {
    icon: 'cakeIcon',
    description: 'В стоимость торта входит минимальный декор. Особые пожелания обговариваются в индивидуальном порядке',
  },
]
</script>

<template>
  <section class="details container">
    <h2>Подробности</h2>
    <div class="details-items">
      <Card
        v-for="element in details"
        :key="element.icon"
        :item="element"
      />
    </div>
    <div class="details-info">
      <span class="gradient bodyBold">Остались вопросы?</span>
      <span class="bodyBold">Свяжитесь с нашим оператором —</span>
      <PhoneNumber :is-active-img="true" />
    </div>
  </section>
</template>

<style scoped lang="scss">
.details {
  display: flex;
  flex-direction: column;
  gap: $cover-32;

  h2 {
    color: $color-opacity06;
  }

  &-items {
    display: flex;
    align-items: flex-start;
    align-content: flex-start;
    gap: $cover-24;
  }

  &-info {
    display: flex;
    gap: $cover-8;

    .gradient {
      background: $color-gradient;
      background-clip: text;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
  }
}
</style>
