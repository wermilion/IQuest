<script setup lang="ts">
import { computed, ref } from 'vue'
import Tag from './tag-component.vue'
import type { Quest } from '#/types/models/quest'

interface Props {
  quest: Quest
  isHover: boolean
}

const props = defineProps<Props>()

const hoverActive = ref(props.isHover)

const tags = computed(() => [props.quest.genre?.name, props.quest.type?.name])
</script>

<template>
  <div class="hover-container" :class="{ 'hover-active': hoverActive }">
    <div v-if="hoverActive" class="hover">
      <svg
        width="32"
        height="400"
        viewBox="0 0 32 400"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          clip-rule="evenodd"
          d="M0 9.45274C0 4.23213 4.12441 0 9.21212 0H28.1212V2.98507H9.21212C5.73105 2.98507 2.90909 5.88074 2.90909 9.45274V390.547C2.90909 394.119 5.73105 397.015 9.21212 397.015H32V400H9.21212C4.12441 400 0 395.768 0 390.547V9.45274Z"
          fill="white"
          fill-opacity="0.75"
        />
      </svg>
      <span class="hover-before footnote">
        {{ quest.min_people }}-{{ quest.max_people }} игрока
      </span>
    </div>
    <router-link to="/" class="card" :class="{ hoverActive }">
      <div class="card-image">
        <img
          loading="lazy"
          :src="`/quest-photo/${quest.cover}.png`"
          :alt="quest.cover"
        >
      </div>

      <div class="card-body">
        <span class="bodyBold">{{ quest.name }}</span>
        <div class="card-body__tags">
          <Tag v-for="tag in tags" :key="tag" :name="tag" />
        </div>
        <p
          v-if="quest.short_description"
          class="card-body__description footnote"
        >
          {{ quest.short_description }}
        </p>
      </div>
    </router-link>
    <div v-if="hoverActive" class="hover">
      <span class="hover-after footnote"> {{ quest.duration }} мин </span>
      <svg
        width="32"
        height="400"
        viewBox="0 0 32 400"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          clip-rule="evenodd"
          d="M32 9.45274C32 4.23213 27.8756 0 22.7879 0H3.87879V2.98507H22.7879C26.2689 2.98507 29.0909 5.88074 29.0909 9.45274V390.547C29.0909 394.119 26.2689 397.015 22.7879 397.015H0V400H22.7879C27.8756 400 32 395.768 32 390.547V9.45274Z"
          fill="white"
          fill-opacity="0.6"
        />
      </svg>
    </div>
  </div>
</template>

<style scoped lang="scss">
.card {
  width: 400px;
  max-height: 400px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: center;

  transition: $hover-animation;

  border-radius: $cover-8;
  border: 1px solid $color-opacity004;

  &-image {
    width: 100%;
    height: 100%;
    overflow: hidden;
  }

  img {
    height: 100%;
    width: 100%;
    object-fit: cover;
  }

  &-body {
    max-height: 152px;
    background: $color-opacity004;
    backdrop-filter: blur(50px);
    padding: $cover-24;
    display: flex;
    flex-direction: column;
    gap: $cover-36;

    transition: $hover-animation;

    span {
      color: $color-base2;
    }

    &__tags {
      display: flex;
      flex-wrap: wrap;
      gap: $cover-8;
    }

    &__description {
      transform: translateY(100%);
      transition: $hover-animation;
    }
  }
}

.hover-container {
  display: flex;

  .hover {
    position: relative;

    &-before,
    &-after {
      position: absolute;
      width: max-content;

      opacity: 0;
      transition: $hover-animation;
    }

    &-before {
      left: 40px;
      top: -10px;
    }

    &-after {
      bottom: -10px;
      right: 40px;
    }

    svg {
      opacity: 0;
      position: absolute;
      transition: $hover-animation;
      top: 1px;
      &:last-child {
        right: 1px;
      }
    }
  }
}

.hover-active {
  &:hover {
    .hover {
      &-before,
      &-after {
        opacity: 1;
      }

      svg {
        opacity: 1;
      }
    }

    .card {
      transform: scale(0.84);

      &-body {
        max-height: 100%;

        &__description {
          transform: translateY(0);
        }
      }
    }
  }

  &:not(:hover) {
    .card-body {
      max-height: 152px;

      &__description {
        transform: translateY(100%);
      }
    }
  }
}
</style>
