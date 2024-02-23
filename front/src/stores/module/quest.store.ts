import { defineStore } from 'pinia'
import type { Quest } from '#/types/models/quest'
import { api } from '#/utils/api'

//* --- State ----------------------------------------------- *//
interface QuestState {
  quests: Quest[]
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useQuestStore = defineStore('quest', {
  state: (): QuestState => ({
    quests: [],
    error: {},
  }),
  actions: {
    async fetchQuests() {
      try {
        const response = await api.quest.getSearch({
          include: ['type', 'genre', 'room.filial', 'images'],
          filter: {
            city: 'Томск',
            is_active: true,
          },
        })
        this.quests = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },
})
