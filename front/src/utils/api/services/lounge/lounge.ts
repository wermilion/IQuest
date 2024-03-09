import type { AxiosInstance, AxiosPromise } from 'axios'
import type { SearchLoungeRequest } from './lounge.type'
import type { Lounge } from '#/types/models/lounge'

export default (instance: AxiosInstance) => ({
  getLoungeList(payload: SearchLoungeRequest): AxiosPromise<{ data: Lounge[] }> {
    return instance.post('/lounges:search', payload)
  },
})
