import { defineStore } from 'pinia'
import { api } from '#/utils/api'
import type { Stocks } from '#/types/models/stocks'

//* --- State ----------------------------------------------- *//
interface StockstState {
  stocks: Stocks[] | null
  error: unknown
}

//* --- Store ----------------------------------------------- *//
export const useStocksStore = defineStore('stocks', {
  state: (): StockstState => ({
    stocks: null,
    error: {},
  }),
  actions: {
    async fetchStocks() {
      try {
        const response = await api.stocks.getStocks({
          include: [],
          filter: {
            city: 'Томск',
            is_active: true,
          },
        })
        this.stocks = response.data.data
      }
      catch (error) {
        this.error = error
      }
    },
  },

})
