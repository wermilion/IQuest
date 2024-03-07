<script setup lang="ts">
import { vMaska } from 'maska'
import Modal from '#/components/shared/modal.vue'
import { checkboxRules, nameRules, phoneRules } from '#/utils/helpers/rules'
import { options } from '#/utils/helpers/maska'
import Button from '#/components/shared/button.vue'

const modal = defineModel<boolean>()

const formData = reactive({
  fullName: '',
  phoneNumber: '',
  privatePolice: false,
})

function submitForm() {
  if (!formData.fullName || !formData.phoneNumber || !formData.privatePolice)
    return

  api.booking.postBooking({
    booking: {
      name: formData.fullName,
      phone: formData.phoneNumber,
      type: 'Праздник',
      city_id: 1,
    },
    holiday: {
      holiday_id: 3,
      package_id: 3,
    },
  })

  formData.fullName = ''
  formData.phoneNumber = ''
  formData.privatePolice = false
  modal.value = false
}

const modalProps = computed(() => ({
  title: 'Оформление',
  subTitle: `Корпоратив`,
}))
</script>

<template>
  <Modal v-model="modal" persistent v-bind="modalProps">
    <template #content>
      <div class="content-wrapper">
        <v-form class="form">
          <v-text-field
            v-model.lazy.trim="formData.fullName"
            :rules="nameRules"
            color="primary"
            variant="underlined"
            label="Имя"

            required
          />
          <v-text-field
            v-model="formData.phoneNumber"
            v-maska:[options]
            :rules="phoneRules"
            required
            color="primary"
            variant="underlined"
            label="Мобильный телефон"
          />
          <div class="price-info">
            <h3>От 600₽ с человека</h3>
          </div>
        </v-form>
      </div>
    </template>
    <template #footer>
      <div class="footer-checkbox">
        <v-checkbox
          v-model="formData.privatePolice"
          :class="{ active: formData.privatePolice }"
          :rules="checkboxRules"
          required
          label="Я даю согласие на обработку персональных данных"
        />
        <Button
          name="Оформить заявку"
          type="submit"
          :button-light="true"
          :disabled="!formData.fullName || !formData.phoneNumber || !formData.privatePolice"

          @click="submitForm"
        />
      </div>
    </template>
  </Modal>
</template>

<style scoped lang="scss">
.active {
  color: $color-base2;
}

.form {
  display: flex;
  flex-direction: column;
  gap: $cover-12;
}

.content-wrapper {
  display: flex;
  flex-direction: column;
  gap: $cover-32;
}

.price-info {
  display: flex;
  align-items: center;
  gap: $cover-8;
}
.footer-checkbox {
  display: flex;
  flex-direction: column;
  gap: $cover-12;
}

input h2 {
  color: $color-opacity06;
}

h3 {
  color: $color-base2;
}
</style>
