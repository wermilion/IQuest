<script setup lang="ts">
import QuestInfo from './info/quest-info.vue'
import QuestImages from './quest-images.vue'
import QuestDescription from './quest-description.vue'
import Arrow from '#/assets/svg/shared/arrow.svg?component'
import type { Quest } from '#/types/models/quest'

defineProps<{
  quest: Quest
}>()
</script>

<template>
  <section class="container">
    <div>
      <router-link class="back" to="/">
        <Arrow />
        <span class="footnote">назад</span>
      </router-link>
    </div>
    <div class="main-container">
      <div class="photo-description">
        <QuestImages />
        <QuestDescription />
      </div>
      <QuestInfo :info="quest" />
    </div>
  </section>
</template>

<style scoped lang="scss">
.container {
  padding-top: 120px;
  display: flex;
  flex-direction: column;
  gap: $cover-16;
  width: 100%;
}
.photo-description {
  max-width: 616px;
  display: flex;
  flex-direction: column;
  gap: $cover-32;
}

.main-container {
  display: flex;
  justify-content: space-between;
}
.back {
  width: max-content;
  display: flex;
  justify-content: center;
  align-items: flex-end;
  padding: 3px 0px 5px 0px;
  gap: $cover-4;
  transition: $hover-anim-btn;

  &:hover {
    span {
      color: $color-base2;
    }
    :deep(path){
      stroke-opacity: 1;
    }
  }
}
</style>
