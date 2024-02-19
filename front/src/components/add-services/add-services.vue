<script setup lang="ts">
import card from "#/components/card/card-component.vue";
import { ref } from "vue";

const lounge = ref({
  name: "Лаунж зона",
  img: "lounge",
  tags: ["600р/30 мин • 1000р/1 час"],

  hoverActive: false,
});

const items = ref([
  {
    name: "Мастер-класс",
    price: "450₽/чел",
  },
  {
    name: "Настольные игры в лаунж",
    price: "500₽/60 мин",
  },
  {
    name: "Снимок на Polaroid",
    price: "500₽/шт",
  },
  {
    name: "Игра «Угадай кто?»",
    price: "450₽/30 мин",
  },
  {
    name: "Игротека на выезд",
    price: "3000₽/3 часа",
  },
  {
    name: "Съемка в локации квеста",
    price: "3000₽/60 мин",
  },
]);
</script>

<template>
  <section class="add-services container">
    <div class="add-services__body">
      <h2>Доп услуги</h2>
      <div class="add-services__info">
        <div class="add-services__info-header d-flex">
          <span class="body">
            <img src="/icons/phone.svg" alt="phone" />
            <p>94-29-10</p>
          </span>
          <span class="footnote">подробности у нашего оператора</span>
        </div>
        <div class="add-services__info-list">
          <div
            class="add-services__info-item"
            v-for="item in items"
            :key="item.name"
          >
            <span class="body">{{ item.name }}</span>
            <span class="footnote">{{ item.price }}</span>
          </div>
        </div>
      </div>
    </div>
    <card :="lounge" />
  </section>
</template>

<style scoped lang="scss">
.add-services {
  width: 100%;
  display: inline-flex;
  padding: $cover-40;
  justify-content: space-between;
  gap: 102px;
  border-radius: $cover-12;
  border: 2px solid $color-opacity025;

  @media screen and (max-width: 1200px) {
    flex-wrap: wrap;
  }

  &__body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    width: 100%;
    gap: $cover-32;
    max-width: 722px;

    @media screen and (max-width: 1200px) {
      max-width: 100%;
    }
  }

  &__info {
    display: flex;
    flex-direction: column;
    gap: $cover-24;

    &-header {
      gap: $cover-12;
      align-items: center;

      span {
        display: flex;

        &:first-child {
          gap: $cover-8;
        }
      }
    }

    &-list {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 16px;
    }

    &-item {
      display: flex;
      width: 100%;
      justify-content: space-between;
      padding-bottom: 4px;
      border-bottom: 1px solid $color-opacity025;
    }
  }
}
</style>
