<script setup lang="ts">
import { vMaska } from 'maska'
import Modal from '#/components/shared/modal.vue'
import {
  checkboxRules,
  nameRules,
  phoneRules,
  regexName,
  regexNumber,
  validateField,
  validateLength,
} from '#/utils/helpers/rules'
import { options } from '#/utils/helpers/maska'
import Button from '#/components/shared/button.vue'
import type { ResultModal } from '#/types/shared/common'

const emits = defineEmits<{ submit: [ResultModal] }>()
const modal = defineModel<boolean>()
const stores = setupStore(['city'])
const formData = reactive({
  fullName: '',
  phoneNumber: '',
  privatePolice: false,
})

const modalProps = computed(() => ({
  title: 'Оформление',
  subTitle: `Корпоратив`,
}))

const guard = ref(true)

async function submitForm() {
  if (
    !validateField(formData.fullName, regexName)
    || !validateLength(formData.fullName, 4, 30)
    || !validateField(formData.phoneNumber, regexNumber)
    || !formData.privatePolice
  )
    return
  try {
    await api.booking.postBooking({
      booking: {
        name: formData.fullName,
        phone: formData.phoneNumber,
        type: 'Праздник',
        city_id: stores.city.selectedCity.id,
      },
      holiday: {
        holiday_id: 3,
        package_id: 1,
      },
    })
    emits('submit', { status: 'success', info: modalProps.value })
  }
  catch (e) {
    emits('submit', { status: 'failed', info: modalProps.value })
  }
  finally {
    formData.fullName = ''
    formData.phoneNumber = ''
    formData.privatePolice = false
    modal.value = false
  }
}

watch(formData, (newValue, _oldValue) => {
  const allFieldsValid = (
    validateField(newValue.fullName, regexName)
    && validateLength(newValue.fullName, 4, 30)
    && validateField(newValue.phoneNumber, regexNumber)
    && newValue.privatePolice
  )
  if (allFieldsValid)
    guard.value = false
  else
    guard.value = true
}, { deep: true, immediate: true })
</script>

<template>
  <Modal v-model="modal" v-bind="modalProps">
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
