<script setup lang="ts">
defineProps<{ type: string }>()
</script>

<template>
  <div class="cover">
    <div
      class="cover-container"
      :class="{
        man: type === 'Взрослый праздник',
        child: type === 'Детский праздник',
      }"
    >
      <div class="container">
        <h2>{{ type }}</h2>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.cover {
  margin-top: 88px;
  height: 555px;
  position: relative;

  &-container, .man, .child {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    display: flex;
    align-items: flex-end;
  }

  .container {
    position: relative;
    z-index: 2;
    margin-bottom: 108px;
  }
}

.man {
  background:
    linear-gradient(180deg, #151116 0%, rgba(21, 17, 22, 0.00) 49%, #151116 96%),
    url('/holidays/man.jpg'), lightgray 50% / cover no-repeat;
}

.child {
  background:
    linear-gradient(180deg, #151116 0%, rgba(21, 17, 22, 0.00) 49%, #151116 96%),
    url('/holidays/child.jpg'), lightgray 50% / cover no-repeat;
}
</style>
