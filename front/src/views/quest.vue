<script setup lang="ts">
import QuestContainer from '#/components/quest-view/quest/quest-container.vue'
import QuestBooking from '#/components/quest-view/booking/booking.vue'
import AddServices from '#/components/shared/add-services.vue'
import QuestCardGrid from '#/components/shared/quest-card-grid.vue'

const route = useRoute()

const stores = setupStore(['quest', 'services'])
stores.quest.fetchQuest(`${route.params.id}`)

onMounted(() => {
  stores.services.fetchServices()
})
</script>

<template>
  <section v-if="stores.quest.quest" class="quest">
    <QuestContainer v-if="stores.quest.quest" :quest="stores.quest.quest" />
    <QuestBooking v-if="stores.quest.quest" :id-quest="stores.quest.quest.id" />
    <AddServices />
    <QuestCardGrid />
  </section>
  <section v-else class="loading">
    <h2>Я не придумал что вставить ;)</h2>
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
