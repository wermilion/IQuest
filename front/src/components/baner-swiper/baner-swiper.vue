<script setup lang="ts"></script>

<template>
  <section class="bg-secondary">
    <div class="baner-swiper container">
      <div class="baner-swiper__body">
        <div class="baner-swiper__body-text">
          <h1>скидка 1000₽ на игру вдвоём</h1>
          <p class="body">
            Забронируйте квест на 2 человека и скажите оператору про скидку
          </p>
        </div>
      </div>
      <div class="baner-swiper__image">
        <div class="baner-front">
          <img loading="lazy" src="/quest-photo/photo.png" alt="baner" />
        </div>
        <div class="baner-back">
          <img loading="lazy" src="/quest-photo/photo.png" alt="baner" />
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">
.bg-secondary {
  background-image: url(/gradient/baner-gradient.svg);
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  height: 316px;
}
.baner-swiper {
  display: flex;
  justify-content: space-between;
  overflow: hidden;
  height: 100%;

  &__body {
    display: flex;
    margin-top: 48px;

    &-text {
      display: flex;
      flex-direction: column;
      gap: $cover-12;
      max-width: 596px;
    }

    &-controler {
      display: flex;
      align-items: center;
    }
  }

  &__image {
    display: flex;
    position: relative;
  }
}

.baner {
  &-front {
    position: absolute;
    right: 174px;
    top: 22px;
    z-index: 1;
    width: 364px;
    height: 310px;
    display: flex;
    transform: rotate(-8deg);
    padding: 12px 12px 68px 12px;
    border-radius: $cover-8;
    border: 0.5px solid $color-shade-5;
    background: $color-shade-1;
  }
  &-back {
    margin-top: 71px;
    width: 321px;
    height: 272px;
    display: flex;
    transform: rotate(4deg);
    padding: 10px 10px 59px 10px;
    border-radius: $cover-8;
    border: 0.5px solid $color-shade-5;
    background: $color-shade-1;
  }
}

img {
  width: 100%;
  border-radius: $cover-4;
}

.element {
  display: flex;
  width: 100%;
  height: 6px;
  border-radius: $cover-2;
  background-color: $color-opacity004;

  &-container {
    min-width: 192px;
    display: flex;
    gap: $cover-8;
  }
}
</style>
