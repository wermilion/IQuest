<script setup lang="ts">
import BookingModal from '#/components/holidays-view/corporative/modal/booking-modal.vue'
import Button from '#/components/shared/button.vue'

export interface Props {
  type: string
  corpInfo?: boolean
}
defineProps<Props>()

const modal = ref(false)

function openModal() {
  modal.value = true
}
</script>

<template>
  <div class="cover">
    <div
      class="cover-container"
      :class="{
        man: type === 'Взрослый праздник',
        child: type === 'Детский праздник',
        corp: type === 'Корпоратив',
      }"
    >
      <div class="container cover-info" :class="{ corpInfo }">
        <h1>{{ type }}</h1>
        <div v-if="corpInfo" class="cover-info__btn">
          <Button :button-light="true" name="Оставить заявку" @click="openModal()" />
          <span class="body">От 600₽ с человека</span>
        </div>
        <BookingModal
          v-model="modal"
        />
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.cover {
  margin-top: 88px;
  height: 555px;
  position: relative;

  &-container,
  .man,
  .child,
  .corp {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    display: flex;
    align-items: flex-end;
  }

  &-info {
    position: relative;
    display: flex;
    flex-direction: column;
    gap: $cover-32;
    z-index: 2;
    margin-bottom: 108px;

    &__btn {
      display: flex;
      max-width: 545px;
      align-items: center;
      gap: $cover-16;

      a {
        max-width: 295px;
      }
    }
  }
}

.corpInfo {
  margin-bottom: 52px;
}

.man {
  background:
    linear-gradient(180deg, #151116 0%, rgba(21, 17, 22, 0) 49%, #151116 96%),
    url('/holidays/man.jpg'),
    lightgray 50% / cover no-repeat;
}

.child {
  background:
    linear-gradient(180deg, #151116 0%, rgba(21, 17, 22, 0) 49%, #151116 96%),
    url('/holidays/child.jpg'),
    lightgray 50% / cover no-repeat;
}

.corp {
  background:
    linear-gradient(180deg, #151116 0%, rgba(21, 17, 22, 0) 49%, #151116 96%),
    url('/holidays/coop.jpg'),
    lightgray 50% / cover no-repeat;
}
</style>
