<script setup lang="ts">
import Close from '#/assets/svg/shared/close.svg?component'

interface Props {
  title?: string
  subTitle?: string
}

defineProps<Props>()

const model = defineModel<boolean>()
</script>

<template>
  <v-dialog v-model="model">
    <div class="modal-wrapper">
      <div class="modal-header">
        <div class="modal-header__title">
          <h2>{{ title }}</h2>
          <span class="footnote">{{ subTitle }}</span>
        </div>
        <Close class="pointer close" @click="model = false" />
        <slot name="header" />
      </div>
      <div class="modal-content">
        <slot name="content" />
      </div>
      <div class="modal-footer">
        <slot name="footer" />
      </div>
    </div>
  </v-dialog>
</template>

<style scoped lang="scss">
.modal {
  &-wrapper {
    overflow: auto;
    background-color: $color-base1;
    padding: $cover-32;
    border-radius: $cover-12;
    width: 100%;
    max-width: 624px;
    display: flex;
    flex-direction: column;
    gap: $cover-40;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  &-header {
    display: flex;
    justify-content: space-between;

    &__title {
      display: flex;
      flex-direction: column;
      gap: $cover-8;
      max-width: 472px;
    }

    .close {
      :deep() {
        transition: all 0.15s ease-out;
        border-radius: 100%;
      }

      &:hover {
        background-color: $color-red-opacity05;
      }
    }
  }

  &-content {
    display: flex;
    flex-direction: column;
    gap: $cover-32
  }
}
</style>
