<script setup lang="ts">
const loundge = {
  name: 'Лаунж зона',
  img: 'loundge',
  tag: '600р/30 мин • 1000р/1 час',
}
</script>

<template>
  <div class="hover-container pointer">
    <div class="card">
      <div class="card-image">
        <img v-lazy-src="`/loundge/${loundge.img}.jpg`" :alt="loundge.img">
      </div>
      <div class="card-body">
        <span class="bodyBold">{{ loundge.name }}</span>
        <div class="tag">
          <span class="smallFootnote">{{ loundge.tag }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.card {
  width: 400px;
  max-height: 400px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: center;

  border-radius: $cover-8;
  border: 1px solid $color-opacity004;

  &-image {
    width: 100%;
    height: 100%;
    overflow: hidden;
  }

  img {
    height: 100%;
    width: 100%;
    object-fit: cover;
  }

  &-body {
    max-height: 152px;
    background: $color-opacity004;
    backdrop-filter: blur(50px);
    padding: $cover-24;
    display: flex;
    flex-direction: column;
    gap: $cover-36;
  }
}

.tag {
  width: max-content;
  display: flex;
  padding: $cover-8 $cover-12;
  gap: $cover-8;
  align-items: center;
  border-radius: 120px;
  border: 1px solid $color-opacity004;
  background: $color-opacity004;
}

.hover-container {
  display: flex;
}
</style>
