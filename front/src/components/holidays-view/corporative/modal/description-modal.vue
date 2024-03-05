<script setup lang="ts">
import Modal from '#/components/shared/modal.vue'
import Button from '#/components/shared/button.vue'

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
  <Modal v-model="modal" persistent v-bind="modalProps">
    <template #content>
      <p class="footnoteText">
        {{ description }}
      </p>
    </template>
    <template #footer>
      <Button
        name="Оформить заявку"
        type="submit"
        :button-light="true"
      />
    </template>
  </Modal>
</template>
