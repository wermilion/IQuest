<script setup lang="ts">
import card from "#/components/card/card-component.vue";
import { ref } from "vue";

const quests = ref([
  {
    name: "Кутёж в ирландском пабе",
    img: "photo",
    tags: ["Комедия", "Квест в реальности"],
    minDescription:
      "Вау! Вы, команда самых крутых барменов России, выиграли стажировку в одном из самых крутых заведений Лондона - в пабе «Багровый олень»!",
    time: 60,
    minPerson: 2,
    maxPerson: 6,
  },
  {
    name: "Кутёж в ирландском пабе",
    img: "photo",
    tags: ["Комедия", "Квест в реальности"],
    minDescription:
      "Вау! Вы, команда самых крутых барменов России, выиграли стажировку в одном из самых крутых заведений Лондона - в пабе «Багровый олень»!",
    time: 60,
    minPerson: 2,
    maxPerson: 6,
  },
  {
    name: "Кутёж в ирландском пабе",
    img: "photo",
    tags: ["Комедия", "Квест в реальности"],
    minDescription:
      "Вау! Вы, команда самых крутых барменов России, выиграли стажировку в одном из самых крутых заведений Лондона - в пабе «Багровый олень»!",
    time: 60,
    minPerson: 2,
    maxPerson: 6,
  },
]);
</script>

<template>
  <section class="cards container">
    <h2>Наши квесты</h2>
    <div class="d-flex cards-grid">
      <card v-for="quest in quests" :key="quest.name" :="quest" />
    </div>
  </section>
</template>

<style scoped lang="scss">
h2 {
  color: $color-base2;
}
.cards {
  display: flex;
  flex-direction: column;
  gap: $cover-32;

  &-grid {
    justify-content: center;
    align-items: center;
    align-content: center;
    gap: $cover-32;
    flex-wrap: wrap;
  }
}
</style>
