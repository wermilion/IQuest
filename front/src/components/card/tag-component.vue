<script setup lang="ts">
import { ref } from "vue";

interface Props {
  name: string;
}

const props = defineProps<Props>();
const imageExists = ref(true);

const checkImageExists = (url: string) => {
  const img = new Image();
  img.src = url;
  img.onload = () => {
    imageExists.value = true;
  };
  img.onerror = () => {
    imageExists.value = false;
  };
};

// Проверяем, существует ли изображение в текущей папке
checkImageExists(`/icons/genre/${props.name}.png`);
</script>

<template>
  <div class="tag">
    <img
      loading="lazy"
      v-if="imageExists"
      :src="`/icons/genre/${props.name}.png`"
      :alt="props.name"
    />
    <img
      v-else
      loading="lazy"
      :src="`/icons/type/${props.name}.png`"
      :alt="props.name"
    />

    <span class="smallFootnote">{{ props.name }}</span>
  </div>
</template>

<style scoped lang="scss">
.tag {
  display: flex;
  padding: $cover-8;
  gap: $cover-8;
  align-items: center;
  border-radius: $cover-8;
  border: 1px solid $color-opacity004;
  background: $color-opacity004;
}
</style>
