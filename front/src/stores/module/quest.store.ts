import { defineStore } from 'pinia'
import type { Quest } from '#/types/models/quest'

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
          include: ['type', 'genre', 'filial', 'images', 'age_limit'],
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
