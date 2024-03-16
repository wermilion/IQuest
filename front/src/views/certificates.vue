<script setup lang="ts">
import CertificateMain from '#/components/сertificate/сertificate-main.vue'

const stores = setupStore('сertificateList')

onMounted(() => {
  stores.fetchCertificates()
})
</script>

<template>
  <section v-if="stores.getFirstCertificate" class="container">
    <CertificateMain />
  </section>
  <template v-else>
    <div class="loading">
      <h1>
        Загрузка сертификатов
      </h1>
    </div>
  </template>
</template>

<style scoped lang="scss">
.container {
  margin-top: clamp(40px, 10vw, 144px);
}
</style>
