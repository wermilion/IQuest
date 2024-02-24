<script setup lang="ts">
import { ref } from 'vue'

const description = 'ВАУ! Вы - команда крутейших барменов России выиграли стажировку в одном из самых популярных пабов Лондона! Он знаменит своим фирменным коктейлем, рецепт которого хранится в строжайшем секрете. После месяца вашей работы пришёл день, когда должно решиться - останетесь вы здесь, или вам придётся возвращаться обратно на родину. Совпало так, что в этот же вечер - день рождения местного бармена, с которым вы успели сильно подружиться... Вы выпили ВЕСЬ алкоголь, который был в пабе, попутно разбив телевизор и сломав вешалку. Проснувшись наутро, вы поняли, что если старший бармен увидит все это, то о работе здесь не будет и речи. Вам срочно нужно что-то придумать, ведь до его прихода остался час...'

const isExpanded = ref(false)

function toggleExpand() {
  isExpanded.value = !isExpanded.value
}
</script>

<template>
  <div class="description">
    <h3>Описание</h3>
    <div class="description-content">
      <p class="body" :class="{ expanded: isExpanded }">
        {{ description }}
      </p>
      <button @click="toggleExpand">
        {{ isExpanded ? 'Свернуть' : 'Читать дальше' }}
      </button>
    </div>
  </div>
</template>

<style scoped lang="scss">
.description {
  display: flex;
  flex-direction: column;
  gap: $cover-12;

 .description-content {
    p {
      display: -webkit-box;
      -webkit-box-orient: vertical;
      overflow: hidden;
      transition: all 1s ease;
    }

    p.expanded {
      -webkit-line-clamp: unset;
      max-height: 1000px;
    }

    p:not(.expanded) {
      -webkit-line-clamp: 3;
      max-height: 84px;
    }
  }
}
</style>
