<script setup lang="ts">
defineProps<{ isActiveImg?: boolean }>()

const store = setupStore('contact')

const email = ref({
  text: store.getEmail,
  img: 'mail',
  link: `mailto:${store.getEmail}`,
})

watch(() => store.getEmail, () => {
  email.value.text = store.getEmail
})
</script>

<template>
  <span v-if="store.getEmail" class="body">
    <img v-if="isActiveImg === false" :src="`/icons/share/${email.img}.svg`" :alt="email.img">
    <a :href="email.link">{{ email.text }}</a>
  </span>
</template>

<style scoped lang="scss">
  span {
  display: flex;
  align-items: center;
  gap: 8px;
  a {
    color: $color-base2;
  }
}
</style>
