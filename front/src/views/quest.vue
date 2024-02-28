<script setup lang="ts">
import QuestContainer from '#/components/quest-view/quest/quest-container.vue'
import QuestBooking from '#/components/quest-view/booking/booking.vue'
import AddServices from '#/components/shared/add-services.vue'
import QuestCardGrid from '#/components/shared/quest-card-grid.vue'

const route = useRoute()

const questStore = setupStore('quest')
questStore.fetchQuest(`${route.params.id}`)
</script>

<template>
  <section class="quest">
    <QuestContainer v-if="questStore.quest" :quest="questStore.quest" />
    <QuestBooking v-if="questStore.quest" :id-quest="questStore.quest.id" />
    <AddServices />
    <QuestCardGrid />
  </section>
</template>

<style scoped lang="scss">
.quest {
  display: flex;
  flex-direction: column;
  gap: 108px;

  section:last-child {
    margin-bottom: 108px;
  }
}
</style>
