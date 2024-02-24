<script setup lang="ts">
import { computed, defineComponent } from 'vue'

import Chip from './assist-chip.vue'

import Address from '#/components/shared/address.vue'
import PhoneNumber from '#/components/shared/phone-number.vue'
import Button from '#/components/shared/button.vue'
import type { Quest } from '#/types/models/quest'

import IconFilled from '#/assets/svg/shared/IconFilled.svg?component'
import IconNoneFilled from '#/assets/svg/shared/IconNoneFilled.svg?component'

const props = defineProps<{ info: Quest }>()
const button = 'Оставить заявку'

const Component = defineComponent({
  components: {
    IconFilled,
    IconNoneFilled,
  },
  props: {
    max: Number,
  },
  template: `
     <component
          :is="i > max ? IconNoneFilled : IconFilled"
          v-for="i in 3"
          :key="i"
        />
  `,
})

const chips = computed(() => {
  const {
    type,
    genre,
    age_limit,
    duration,
    level,
    min_people,
    max_people,
  } = props.info

  return [
    { title: `${type.name}` },
    { title: `${genre.name}` },
    { title: `${age_limit?.name}` },
    {
      title: `Сложность ${level?.id}`,
      slot: {
        is: Component,
        props: { max: level?.id },
      },
    },
    { title: `${min_people} - ${max_people} игроков` },
    { title: `${duration} мин` },
  ]
})
</script>

<template>
  <div class="info">
    <div class="info-container">
      <h1>{{ info.name }}</h1>
      <div class="info-contacts d-flex">
        <PhoneNumber />
        <Address :address="info.room?.filial.address" />
      </div>
      <div class="info-details">
        <Chip v-for="item in chips" :key="item.title" :name="item.title">
          <component
            v-bind="item.slot?.props"
            :is="item.slot?.is"
          />
        </Chip>
      </div>
    </div>
    <Button :name="button" :button-ligh="true" />
  </div>
</template>

<style scoped lang="scss">
.info {
  max-width: 616px;
  max-height: 411px;
  position: sticky;
  display: flex;
  flex-direction: column;
  justify-content: space-between;

  &-container {
    display: flex;
    flex-direction: column;
    gap: $cover-32;
  }

  &-contacts {
    gap: $cover-32;
  }

  &-details {
    display: flex;
    flex-wrap: wrap;
    gap: $cover-16;
  }
}
</style>
