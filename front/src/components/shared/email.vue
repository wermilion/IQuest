<script setup lang="ts">
defineProps<{ isActiveImg?: boolean }>()

const store = setupStore('contact')

onMounted(() => {
  store.fetchEmail()
})

const email = ref({
  text: '',
  img: '',
})

watch(() => store.emial, (newValue) => {
  if (newValue.length) {
    email.value = {
      text: newValue[0].value!,
      img: 'mail',
    }
  }
})
</script>

<template>
  <span class="body">
    <img v-if="isActiveImg === false" :src="`/icons/share/${email.img}.svg`" :alt="email.img">
    <span>{{ email.text }}</span>
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
