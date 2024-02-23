<script setup lang="ts">
import { onMounted } from 'vue'
import card from '#/components/card/card-component.vue'
import { setupStore } from '#/stores/combine-stores'

const questStore = setupStore('quest')

onMounted(() => {
  questStore.fetchQuests()
})
</script>

<template>
  <section class="cards container">
    <h2>Наши квесты</h2>
    <div class="d-flex cards-grid">
      <card
        v-for="quest in questStore.quests"
        :key="quest.id"
        :is-hover="true"
        :quest="quest"
      />
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
