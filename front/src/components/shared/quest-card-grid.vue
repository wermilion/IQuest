<script setup lang="ts">
import Card from '#/components/quest-card/card-component.vue'

const questStore = setupStore('questList')

const route = useRoute()
</script>

<template>
  <section class="cards container">
    <h2>Наши квесты</h2>
    <div class="d-flex cards-grid">
      <template v-for="quest in questStore.questList" :key="quest.id">
        <Card v-if="quest.id !== +route.params.id" :is-hover="true" :quest="quest" />
      </template>
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
    align-items: center;
    align-content: center;
    gap: $cover-32;
    flex-wrap: wrap;
  }
}
</style>
