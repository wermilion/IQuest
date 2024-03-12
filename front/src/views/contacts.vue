<script setup lang="ts">
import ContactsMain from '#/components/contacts/contacts-main.vue'

const store = setupStore('filialList')

store.fetchFilial()
</script>

<template>
  <section v-if="store.filialList.length" class="container">
    <ContactsMain />
  </section>
  <template v-else>
    <section class="loading">
      <h1>Загрузка контактов</h1>
    </section>
  </template>
</template>

<style scoped>
.container {
  margin-top: 160px;
}
</style>
