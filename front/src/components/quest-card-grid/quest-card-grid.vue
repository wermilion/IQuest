<script setup lang="ts">
import card from "#/components/card/card-component.vue";
import { onMounted, ref, watch } from "vue";
import { useDataStore } from "../../stores/quest/quest";

const quests: any = ref(null);

const dataStore = useDataStore();

onMounted(() => {
  dataStore.fetchQuests();
});

watch(
  () => dataStore.data,
  (newVal) => {
    if (newVal && newVal.data) {
      quests.value = newVal.data;
      console.log(quests.value);
    }
  },
  { immediate: true }
);
</script>

<template>
  <section class="cards container">
    <h2>Наши квесты</h2>
    <div class="d-flex cards-grid">
      <card v-for="quest in quests" :key="quest.id" :="quest" />
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
