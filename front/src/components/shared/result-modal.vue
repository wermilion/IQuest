<script setup lang="ts">
import Button from '#/components/shared/button.vue'

const modal = defineModel<boolean>()
</script>

<template>
  <v-dialog v-model="modal" persistent>
    <div class="modal-wrapper">
      <div class="modal-header">
        <div class="modal-header__title">
          <h2>Успешное</h2>
          <h2>Title</h2>
        </div>
        <span class="footnote">Label</span>
      </div>
      <div class="modal-content">
        <img src="/icons/share/customer-support.svg" alt="customer-support">
        <div class="modal-content__text">
          <span class="body">Оператор перезвонит вам для подтверждения заявки</span>
          <span class="footnote">Будьте на связи:)</span>
        </div>
      </div>
      <div class="modal-footer">
        <Button name="Закрыть" @click="modal = false" />
        <Button :button-light="true" name="Доп услуги" @click="modal = false" />
      </div>
    </div>
  </v-dialog>
</template>

<style scoped lang="scss">
h2 {
  color: $color-green;
}
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
    gap: $cover-48;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  &-header {
    display: flex;
    flex-direction: column;
    gap: $cover-8;
  }

  &-content {
    display: flex;
    gap: $cover-16;
    align-items: center;
    justify-content: center;

    &__text {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
  }

  &-footer {
    display: flex;
    gap: 24px;
  }
}
</style>
