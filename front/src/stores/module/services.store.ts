import { defineStore } from 'pinia'
import type { Services } from '#/types/models/services'

//* --- State ----------------------------------------------- *//
interface ServicesState {
  services: Services[] | null
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useServicesStore = defineStore('services', {
  state: (): ServicesState => ({
    services: null,
    error: {},
  }),
  actions: {
    async fetchServices() {
      try {
        const response = await api.services.getServices({
          include: [],
          filter: {
            city_id: 1,
          },
        })
        this.services = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },

})
