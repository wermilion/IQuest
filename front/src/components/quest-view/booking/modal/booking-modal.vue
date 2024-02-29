<script setup lang="ts">
import { ref } from 'vue'

const showModal = ref(false)
</script>

<template>
  <div>
    <button @click="showModal = true">
      Открыть модальное окно
    </button>

    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <div class="nodal-header__title">
            <h2>Бронирование</h2>
            <span class="footnote">Кутёж в ирландском пабе • 17 февраля, сб • 11:30</span>
          </div>
          <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              fill-rule="evenodd" clip-rule="evenodd"
              d="M22.5845 23.9979L12.0014 13.4146L13.4156 12.0004L23.9987 22.5837L34.5821 12L35.9963 13.4142L25.4129 23.9979L35.9977 34.5829L34.5835 35.9971L23.9987 25.4121L13.4142 35.9968L12 34.5825L22.5845 23.9979Z"
              fill="white" fill-opacity="0.25"
            />
          </svg>
        </div>
        <div class="modal-form">
          <input class="modal-input footnote" placeholder="Имя" type="text">
          <input class="modal-input footnote" placeholder="Имя" type="text">

          <div class="modal-count">
            <span class="smallFootnote">Кол-во человек</span>
            <div class="count" />
            <span>если игроков больше 4 — доплата 500₽ за каждого</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.modal {
  display: block;
  position: fixed;
  z-index: 100;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);

  &-content {
    overflow: hidden;
    background-color: $color-base1;
    padding: $cover-32;
    border-radius: $cover-12;
    width: 100%;
    max-width: 624px;
    display: flex;
    flex-direction: column;
    gap: $cover-40;
  }

  &-header {
    display: flex;
    justify-content: space-between;

    &__title {
      display: flex;
      flex-direction: column;
      gap: $cover-8;
      max-width: 472px;
    }
  }

  &-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: $cover-32
  }

  &-input {
    height: 60px;
    background-color: transparent;
    border: none;
    border-bottom: 1px solid $color-opacity025;
    width: 100%;
    outline: none;
    color: $color-base2;
    padding: 0px;
  }
}

h2 {
  color: $color-opacity06;
}
</style>
