import { defineStore } from 'pinia'
import type { Quest } from '#/types/models/quest'
import { api } from '#/utils/api'

//* --- State ----------------------------------------------- *//
interface QuestState {
  quest: Quest | null
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useQuestStore = defineStore('quest', {
  state: (): QuestState => ({
    quest: null,
    error: {},
  }),
  actions: {
    async fetchQuest(id: string) {
      try {
        const response = await api.quest.getQuest(id, {
          include: ['type', 'genre', 'room.filial', 'images', 'age_limit', 'level', 'scheduleQuests'],
          filter: {
            city: 'Томск',
            is_active: true,
          },
        })
        this.quest = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },

})
