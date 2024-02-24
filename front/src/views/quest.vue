<script setup lang="ts">
import { useRoute } from 'vue-router'
import QuestContainer from '#/components/quest-view/quest/quest-container.vue'
import { setupStore } from '#/stores/combine-stores'

const route = useRoute()

const questStore = setupStore('quest')
questStore.fetchQuest(`${route.params.id}`)
</script>

<template>
  <QuestContainer v-if="questStore.quest" :quest="questStore.quest" />
</template>

<style scoped lang="scss"></style>
