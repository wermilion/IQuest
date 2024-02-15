<script setup lang="ts">
import tag from "./tag-component.vue";

interface Props {
  name: string;
  img: string;
  tags: string[];
}

const props = defineProps<Props>();
</script>

<template>
  <router-link to="#" class="card">
    <img :src="`/quest-photo/${props.img}.png`" alt="" />
    <div class="card-body">
      <span class="bodyBold">{{ name }}</span>
      <div class="card-body__tags">
        <tag v-for="tag in tags" :key="tag" :name="tag" />
      </div>
    </div>
  </router-link>
</template>

<style scoped lang="scss">
.card {
  width: 400px;
  max-height: 400px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: center;

  border-radius: $cover-8;
  border: 1px solid $color-opacity004;

  img {
    width: 100%;
    object-fit: cover;
  }

  &-body {
    background: $color-opacity004;
    backdrop-filter: blur(50px);

    padding: $cover-24;
    display: flex;
    flex-direction: column;
    gap: $cover-36;

    span {
      color: $color-base2;
    }

    &__tags {
      display: flex;
      flex-wrap: wrap;
      gap: $cover-8;
    }
  }
}
</style>
