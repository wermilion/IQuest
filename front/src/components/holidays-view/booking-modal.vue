<script setup lang="ts">
import { vMaska } from 'maska'
import infoPopUpVue from '../shared/info-pop-up.vue'
import { checkboxRules, nameRules, phoneRules } from '#/utils/helpers/rules'
import { options } from '#/utils/helpers/maska'
import type { Packages } from '#/types/models/holiday'
import QuestRules from '#/components/quest-view/booking/modal/quest-rules.vue'
import Modal from '#/components/shared/modal.vue'
import Button from '#/components/shared/button.vue'
import type { ResultModal } from '#/types/shared/common'

interface Props {
  package: Packages
}

const props = defineProps<Props>()
const emits = defineEmits<{ submit: [ResultModal] }>()
const modal = defineModel<boolean>()
const stores = setupStore('holiday')
const formData = reactive({
  fullName: '',
  phoneNumber: '',
  privatePolice: false,
})

const modalProps = computed(() => ({
  title: 'Оформление',
  subTitle: `${stores.holiday?.type} • ${props.package.name}`,
}))

async function submitForm() {
  if (!formData.fullName || !formData.phoneNumber || !formData.privatePolice)
    return
  try {
    await api.booking.postBooking({
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
</script>

<template>
  <Modal v-model="modal" persistent v-bind="modalProps">
    <template #content>
      <div class="content-wrapper">
        <v-form class="form">
          <v-text-field
            v-model="formData.fullName"
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
            <h3>От {{ package?.price }}₽</h3><infoPopUpVue name="Если игроков больше 6 — будет доплата" />
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
