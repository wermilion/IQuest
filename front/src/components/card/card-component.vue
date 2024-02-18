<script setup lang="ts">
import tag from "./tag-component.vue";

interface Props {
  name: string;
  img: string;
  tags: string[];
  link?: string;
}

const props = defineProps<Props>();
</script>

<template>
  <router-link
    :to="link ? link : '/'"
    class="card"
    :class="{ 'no-poineter': !link }"
  >
    <img loading="lazy" :src="`/quest-photo/${img}.png`" :alt="img" />
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

  &-body {
    background: $color-opacity004;
    backdrop-filter: blur(50px);

    padding: $cover-24;
    display: flex;
    flex-direction: column;
    gap: $cover-36;
    height: 100%;

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
