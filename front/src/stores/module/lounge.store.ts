import { defineStore } from 'pinia'
import type { Lounge } from '#/types/models/lounge'

//* --- State ----------------------------------------------- *//
interface LoungeListState {
  loungeList: Lounge[]
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useLoungeListStore = defineStore('loungeList', {
  state: (): LoungeListState => ({
    loungeList: [],
    error: {},
  }),
  actions: {
    async fetchLounge() {
      try {
        const response = await api.lounge.getLoungeList({
          include: ['filial.city'],
          filter: {
            city_id: 1,
            is_active: true,
          },
        })
        this.loungeList = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },

})
