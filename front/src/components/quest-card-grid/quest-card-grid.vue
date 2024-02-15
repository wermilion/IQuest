<script setup lang="ts">
import card from "#/components/card/card-component.vue";
import { ref } from "vue";

const quests = ref([
  {
    name: "Кутёж в ирландском пабе",
    img: "photo",
    tags: ["Комедия", "Квест в реальности"],
  },
  {
    name: "Время пить чай",
    img: "photo",
    tags: ["Детский", "Квест-перфоманс"],
  },
  {
    name: "Время пить чай",
    img: "photo",
    tags: ["Детский", "Квест-перфоманс"],
  },
  {
    name: "Кутёж в ирландском пабе",
    img: "photo",
    tags: ["Комедия", "Квест в реальности"],
  },
  {
    name: "Время пить чай",
    img: "photo",
    tags: ["Детский", "Квест-перфоманс"],
  },
  {
    name: "Время пить чай",
    img: "photo",
    tags: ["Детский", "Квест-перфоманс"],
  },
  {
    name: "Кутёж в ирландском пабе",
    img: "photo",
    tags: ["Комедия", "Квест в реальности"],
  },
  {
    name: "Время пить чай",
    img: "photo",
    tags: ["Детский", "Квест-перфоманс"],
  },
  {
    name: "Время пить чай",
    img: "photo",
    tags: ["Детский", "Квест-перфоманс"],
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
  padding-left: 88px;
}
.cards {
  padding-top: 108px;
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
