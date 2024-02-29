import { defineStore } from 'pinia'

//* --- State ----------------------------------------------- *//
interface useChip {
  selectedChip: string
  selectedDate: string[]
}

//* --- Store ----------------------------------------------- *//
export const useChipStore = defineStore('chip', {
  state: (): useChip => ({
    selectedChip: 'Сегодня',
    selectedDate: [],
  }),
  actions: {
    selectChip(chip: string) {
      this.selectedChip = chip
    },
  },
})
