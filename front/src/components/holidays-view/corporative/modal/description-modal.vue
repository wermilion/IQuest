<script setup lang="ts">
import Modal from '#/components/shared/modal.vue'

interface Props {
  name: string
  description: string
}

const props = defineProps<Props>()
const modal = defineModel<boolean>()

const modalProps = computed(() => ({
  title: `${props.name}`,
}))
</script>

<template>
  <Modal v-model="modal" custom-class="city-modal" v-bind="modalProps">
    <template #content>
      <p class="footnote">
        {{ description }}
      </p>
    </template>
  </Modal>
</template>

<style scoped lang="scss">
.footnote {
  max-height: 300px;
  padding-right: 10px;
  overflow: auto;
}

p::-webkit-scrollbar {
  width: 5px;
}

p::-webkit-scrollbar-track {
  background-color: unset;
}

p::-webkit-scrollbar-thumb {
  background-color: $color-opacity06;
  border-radius: 20px;
}
</style>

<style lang="scss">
.city-modal .modal-wrapper {
  height: auto !important;
  overflow: hidden;
  max-height: 400px;
  gap: $cover-16;

  max-width: 90%;
}

.city-modal .modal-content {
  overflow: auto;
}
</style>
