<script setup lang="ts">
import { vMaska } from 'maska'
import type { Packages } from '../../types/models/holiday'
import infoPopUpVue from '../shared/info-pop-up.vue'
import QuestRules from '#/components/quest-view/booking/modal/quest-rules.vue'
import Modal from '#/components/shared/modal.vue'
import Info from '#/assets/svg/shared/info.svg?component'

import Button from '#/components/shared/button.vue'

interface Props {
  package: Packages
}

const props = defineProps<Props>()
const modal = defineModel<boolean>()
const stores = setupStore('holiday')

const nameRules = [
  (v: string) => !!v || 'Имя обязательно для заполнения',
  (v: string) => (v.length >= 3 && v.length <= 30) || 'Имя должно содержать от 3 до 30 символов',
  (v: string) => /^[a-zA-Zа-яА-Я-]*$/.test(v) || 'Имя может содержать только латинские и/или кириллические буквы и дефисы',
]

const phoneRules = [
  (v: string) => !!v || 'Номер телефона обязателен для заполнения',
]

const checkboxRules = [
  (v: boolean) => !!v || 'Необходимо дать согласие на обработку персональных данных',
]

const options = reactive({
  mask: '+7(###)-###-##-##',
  eager: true,
})

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
      holiday_id: stores.holiday?.id || 0,
      package_id: props.package?.id || 0,
    },
  })

  formData.fullName = ''
  formData.phoneNumber = ''
  formData.privatePolice = false
  modal.value = false
}

const modalProps = computed(() => ({
  title: 'Оформление',
  subTitle: `${stores.holiday?.type} • ${props.package.name}`,
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
            <h3>От {{ props.package?.price }}₽</h3><infoPopUpVue name="Если игроков больше 6 — будет доплата" />
          </div>
        </v-form>
      </div>
      <QuestRules />
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
          name="Забронировать"
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
  gap: $cover-32
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
