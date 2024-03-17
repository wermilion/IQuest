<script setup lang="ts">
import { ref } from 'vue'
import Arrow from '#/assets/svg/shared/arrow=default.svg?component'

defineProps<{ description: string }>()

const isExpanded = ref(false)

function toggleExpand() {
  isExpanded.value = !isExpanded.value
}
</script>

<template>
  <div class="description">
    <span class="bodyBold">Описание</span>
    <div class="description-content">
      <p class="footnote" :class="{ extend: isExpanded }" v-html="description" />
      <div
        class="read-more body pointer"
        :class="{ active: isExpanded }"
        @click="toggleExpand"
      >
        {{ isExpanded ? 'Свернуть' : 'Читать дальше' }}
        <Arrow />
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.animate-text {
  animation: textChange 0.25s ease-in-out;
}

@keyframes textChange {
  0% {
    opacity: 0;
  }

  100% {
    opacity: 1;
  }
}

.read-more {
  width: max-content;
  display: flex;
  gap: $cover-8;
  align-items: center;
  transition: all 0.25s ease-in-out;
  color: $color-opacity06;

  :deep(svg) {
    transform: rotate(0);
    transition: all 0.1s ease-in-out;
    stroke-opacity: 0.6;
  }

  &.active {
    :deep(svg) {
      transform: rotate(180deg);
    }
  }
}

.description {
  display: flex;
  flex-direction: column;
  gap: $cover-12;

  &-content {
    display: flex;
    flex-direction: column;
    gap: $cover-8;

    p {
      display: -webkit-box;
      -webkit-box-orient: vertical;
      overflow: hidden;
      transition: all 0.25s ease-in-out;
      max-height: 72px;
    }

    p.extend {
      max-height: 100%;
    }
  }
}
</style>
