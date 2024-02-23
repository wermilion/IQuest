import type { AxiosInstance, AxiosPromise } from 'axios'
import type { SearchQuestsRequest } from './quest.types'
import type { Quest } from '#/types/models/quest'

export default (instance: AxiosInstance) => ({
  /**
   * Получить <...>
   */
  getSearch(payload: SearchQuestsRequest): AxiosPromise<{ data: Quest[] }> {
    return instance.post('/quests:search', payload)
  },
})
