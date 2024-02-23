// src/store.ts
import { defineStore } from 'pinia';
import { fetchData } from '../api';

export const useDataStore = defineStore('data', {
  state: () => ({
    data: null as any,
    error: null as string | null,
  }),
  actions: {
    async fetchQuests() {
      const path = '/api/quests:search';
      const body = {
        include: ['type', 'genre', 'room.filial', 'images'],
        filter: {
          city: 'Томск',
          is_active: true,
        },
      };
      try {
        const response = await fetchData(path, body);
        this.data = response;
      } catch (error) {
        this.error = (error as Error).message;
      }
    },
  },
});
