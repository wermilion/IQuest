import { defineStore } from 'pinia'
import type { City } from '#/types/models/city'

//* --- State ----------------------------------------------- *//
interface CityState {
  city: City[] | null
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useCityStore = defineStore('city', {
  state: (): CityState => ({
    city: null,
    error: {},
  }),
  actions: {
    async fetchCity() {
      try {
        const response = await api.city.getCities({ })
        this.city = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },

})
