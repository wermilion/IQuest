import { defineStore } from 'pinia'
import { api } from '#/utils/api'
import type { Schedule } from '#/types/models/schedule'
import type { SearchScheduleQuestsRequest } from '#/utils/api/services/quest/quest.types'

//* --- State ----------------------------------------------- *//
interface ScheduleQuestState {
  scheduleQuest: Schedule[]
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useScheduleQuestStore = defineStore('scheduleQuest', {
  state: (): ScheduleQuestState => ({
    scheduleQuest: [],
    error: {},
  }),
  actions: {
    async fetchScheduleQuest(filter: SearchScheduleQuestsRequest['filter']) {
      try {
        const response = await api.quest.getScheduleQuest({
          include: ['timeslots'],
          filter,
        })
        this.scheduleQuest = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },

})
