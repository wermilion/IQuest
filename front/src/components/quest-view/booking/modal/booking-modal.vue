<script setup lang="ts">
import QuestRules from './quest-rules.vue'
import Close from '#/assets/svg/shared/close.svg?component'
import Plus from '#/assets/svg/shared/plus.svg?component'
import Minus from '#/assets/svg/shared/minus.svg?component'
import type { TimeSlots } from '#/types/models/schedule'

import '#/assets/scss/normalize.scss'
import Button from '#/components/shared/button.vue'

const props = defineProps<{
  showModal: boolean
  date: string | null
  item: TimeSlots | null
}>()

const emit = defineEmits(['close'])
const stores = setupStore('quest')

const people = ref(stores.quest?.min_people || 0)
const fullName = ref('')
const phoneNumber = ref('')
const addLoudge = ref(false)
const privatePolice = ref(false)
const totalPrice = computed(() => {
  const basePrice = props.item?.price ? Number.parseFloat(props.item.price) : 0
  const additionalPeople = Math.max(people.value - 4, 0)
  const additionalCost = additionalPeople * 500
  return basePrice + additionalCost
})

function addPeople(): void {
  if (people.value !== undefined && stores.quest?.max_people !== undefined) {
    if (people.value < stores.quest?.max_people)
      people.value++
  }
}

function removePeople(): void {
  if (people.value !== undefined && stores.quest?.min_people !== undefined) {
    if (people.value > stores.quest?.min_people)
      people.value--
  }
}
</script>

<template>
  <div v-if="showModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-header__title">
          <h2>Бронирование</h2>
          <span class="footnote">{{ stores.quest?.name }} • {{ date }} • {{ item?.time.replace(/:00$/, '') }}</span>
        </div>
        <Close class="pointer close" @click="emit('close')" />
      </div>
      <div class="modal-form">
        <form class="form">
          <v-text-field v-model="fullName" variant="underlined" label="Имя" />
          <v-text-field v-model="phoneNumber" type="tel" variant="underlined" label="Мобильный телефон" />
        </form>
        <div class="modal-count">
          <span class="smallFootnote">Кол-во человек</span>
          <div class="count">
            <Minus class="btn pointer" @click="removePeople" />
            <span class="body">{{ people }}</span>
            <Plus class="btn pointer" @click="addPeople" />
          </div>
          <span v-if="people > 4" class="verySmallFootnot">
            если игроков больше 4 — доплата 500₽ за каждого
          </span>
        </div>
        <h3>Итого за квест: {{ totalPrice }}₽</h3>
      </div>
      <QuestRules />
      <div class="modal-checkbox">
        <v-checkbox v-model="addLoudge" label="Хочу лаунж зону" />
        <v-checkbox v-model="privatePolice" label="Я даю согласие на обработку персональных данных" />
        <Button name="Забронировать" :button-ligh="true" @click="emit('close')" />
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.modal {
  display: block;
  position: fixed;
  z-index: 100;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  background-color: rgba(0, 0, 0, 0.4);

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

  &-count {
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

  &-form {
    display: flex;
    flex-direction: column;
    gap: $cover-32
  }

  &-checkbox {
    display: flex;
    flex-direction: column;
    gap: $cover-12;
  }
}

input h2 {
  color: $color-opacity06;
}

h3 {
  color: $color-base2;
}
</style>
