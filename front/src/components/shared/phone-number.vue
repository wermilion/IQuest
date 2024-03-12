<script setup lang="ts">
defineProps<{ isActiveImg?: boolean }>()

const store = setupStore('contact')

onMounted(() => {
  store.fetchPhone()
})

const phoneNumber = ref({
  text: '',
  img: '',
  link: '',
})

watch(() => store.phone, (newValue) => {
  if (newValue.length) {
    phoneNumber.value = {
      text: newValue[0].value!,
      img: 'phone',
      link: `tel:${newValue[0].value!}`,
    }
  }
})
</script>

<template>
  <span class="body">
    <img v-if="isActiveImg === false" :src="`/icons/share/${phoneNumber.img}.svg`" :alt="phoneNumber.img">
    <a :href="phoneNumber.link">{{ phoneNumber.text }}</a>
  </span>
</template>

<style scoped lang="scss">
  span {
  display: flex;
  gap: 8px;
  a {
    color: $color-base2;
  }
}
</style>
