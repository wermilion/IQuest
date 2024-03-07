<script setup lang="ts">
import { vMaska } from 'maska'
import QuestRules from './quest-rules.vue'
import Modal from '#/components/shared/modal.vue'
import Plus from '#/assets/svg/shared/plus.svg?component'
import Minus from '#/assets/svg/shared/minus.svg?component'
import InfoPopUpVue from '#/components/shared/info-pop-up.vue'
import type { TimeSlots } from '#/types/models/schedule'

import Button from '#/components/shared/button.vue'

interface Props {
  date: string | null
  item: TimeSlots
}

const props = defineProps<Props>()
const modal = defineModel<boolean>()
const stores = setupStore('quest')

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
  people: stores.quest?.min_people || 0,
  fullName: '',
  phoneNumber: '',
  addLoudge: false,
  privatePolice: false,
})

const totalPrice = computed(() => {
  const { price = 0 } = props.item
  const basePrice = price
  const additionalPeople = Math.max(formData.people - 4, 0)
  const additionalCost = additionalPeople * 500

  return basePrice + additionalCost
})

function addPeople(): void {
  if (stores.quest?.max_people !== undefined
    && formData.people < stores.quest?.max_people)
    formData.people++
}

function removePeople(): void {
  if (stores.quest?.min_people !== undefined
    && formData.people > stores.quest?.min_people)
    formData.people--
}

function submitForm() {
  if (!formData.fullName || !formData.phoneNumber || !formData.privatePolice)
    return

  api.booking.postBooking({
    booking: {
      name: formData.fullName,
      phone: formData.phoneNumber,
      type: 'Квест',
      city_id: 1,
    },
    schedule_quest: {
      timeslot_id: props.item?.id,
      count_participants: formData.people,
      final_price: totalPrice.value,
      comment: formData.addLoudge ? 'Хочу лаунж' : '',
    },
  })
  modal.value = false
}

const modalProps = computed(() => ({
  title: 'Бронирование',
  subTitle: `${stores.quest?.name} • ${props.date} • ${props.item?.time?.replace(/:00$/, '') ?? ''}`,
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
        </v-form>
        <div class="count-wrapper">
          <span class="smallFootnote">Кол-во человек</span>
          <div class="count">
            <Minus class="btn pointer" @click="removePeople" />
            <span class="body">{{ formData.people }}</span>
            <Plus class="btn pointer" @click="addPeople" />
          </div>
          <span v-if="formData.people > 4" class="verySmallFootnot">
            если игроков больше 4 — доплата 500₽ за каждого
          </span>
        </div>
        <h3>Итого за квест: {{ totalPrice }}₽</h3>
      </div>
      <QuestRules />
    </template>
    <template #footer>
      <div class="footer-checkbox">
        <div class="footer-checkbox__lounge">
          <v-checkbox
            v-model="formData.addLoudge"
            :class="{ active: formData.addLoudge }"
            class="loudge"
            label="Хочу лаунж зону"
          />
          <InfoPopUpVue name="Отдохните и обсудите квест после игры" />
        </div>

        <v-checkbox
          v-model="formData.privatePolice"
          :class="{ active: formData.privatePolice }"
          :rules="checkboxRules"
          required
          label="Я даю согласие на обработку персональных данных"
        />
        <Button name="Забронировать" type="submit" :button-light="true" @click="submitForm" />
      </div>
    </template>
  </Modal>
</template>

<style scoped lang="scss">
.count-wrapper {
  display: flex;
  flex-direction: column;
  gap: $cover-8;
  .count {
    display: flex;
    align-items: center;
    gap: $cover-12;

    .btn {
      :deep() {
        rect {
          transition: all 0.15s ease-in-out;
        }
      }

      &:hover {
        :deep() {
          rect {
            fill-opacity: 0.25;
          }
        }
      }
    }
  }
}

.loudge {
  max-height: 32px;
}

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

.footer-checkbox {
  display: flex;
  flex-direction: column;
  gap: $cover-12;

  &__lounge {
    display: flex;
    align-items: center;
    gap: $cover-4;
  }
}

input h2 {
  color: $color-opacity06;
}

h3 {
  color: $color-base2;
}
</style>
