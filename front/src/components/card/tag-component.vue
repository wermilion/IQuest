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
    <div v-if="imageExists">
      <!-- Если изображение существует в текущей папке, отображаем его -->
      <img
        v-if="imageExists"
        :src="`/icons/genre/${props.name}.png`"
        :alt="props.name"
      />
      <!-- Если изображение не найдено в текущей папке, пытаемся загрузить его из другой папки -->
      <img v-else :src="`/icons/type/${props.name}.png`" :alt="props.name" />
    </div>

    <span class="smallFootnote">{{ props.name }}</span>
  </div>
</template>

<style scoped lang="scss">
.tag {
  display: flex;
  padding: $cover-8;
  justify-content: center;
  align-items: center;
  gap: $cover-8;

  border-radius: $cover-8;
  border: 1px solid $color-opacity004;
  background: $color-opacity004;

  span {
    color: $color-opacity075;
  }
}
</style>
