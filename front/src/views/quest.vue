<script setup lang="ts">
import { useRoute } from 'vue-router'
import QuestContainer from '#/components/quest-view/quest/quest-container.vue'
import QuestBooking from '#/components/quest-view/booking/booking.vue'
import { setupStore } from '#/stores/combine-stores'

const route = useRoute()

const questStore = setupStore('quest')
questStore.fetchQuest(`${route.params.id}`)
</script>

<template>
  <section class="quest">
    <QuestContainer v-if="questStore.quest" :quest="questStore.quest" />
    <QuestBooking v-if="questStore.quest" />
  </section>
</template>

<style scoped lang="scss">
.quest {
  display: flex;
  flex-direction: column;
  gap: 108px;
}
</style>
