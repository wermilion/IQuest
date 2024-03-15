<script setup lang="ts">
defineProps<{ isActiveImg?: boolean }>()

const store = setupStore('contact')

const phoneNumber = ref({
  text: store.getPhone,
  img: 'phone',
  link: `tel:${store.getPhone}`,
})

watch(() => store.getPhone, () => {
  phoneNumber.value.text = store.getPhone
})
</script>

<template>
  <span v-if="store.getPhone" class="body">
    <img v-if="isActiveImg === false" :src="`/icons/share/${phoneNumber.img}.svg`" :alt="phoneNumber.img">
    <a :href="phoneNumber.link">{{ phoneNumber.text }}</a>
  </span>
</template>

<style scoped lang="scss">
  span {
  align-items: center;
  display: flex;
  gap: 8px;
  a {
    color: $color-base2;
  }

  img {
    width: clamp(22px, 5vw, $cover-28);
  }
}
</style>
