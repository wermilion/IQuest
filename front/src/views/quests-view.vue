<script setup lang="ts">
import addServicesVue from "#/components/add-services/add-services.vue";
import QuestCardGrid from "#/components/quest-card-grid/quest-card-grid.vue";
</script>

<template>
  <section class="bg-black">
    <QuestCardGrid />
    <addServicesVue />
  </section>
</template>

<style scoped lang="scss">
.bg-black {
  display: flex;
  flex-direction: column;
  gap: 108px;
}

section:first-child {
  margin-top: 108px;
}

section:last-child {
  margin-bottom: 108px;
}
</style>
