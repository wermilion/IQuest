import { defineStore } from 'pinia'

//* --- State ----------------------------------------------- *//
interface useChip {
  selectedChip: string
}

//* --- Store ----------------------------------------------- *//
export const useChipStore = defineStore('chip', {
  state: (): useChip => ({
    selectedChip: 'Сегодня',
  }),
  actions: {
    selectChip(chip: string) {
      this.selectedChip = chip
    },
  },
})
