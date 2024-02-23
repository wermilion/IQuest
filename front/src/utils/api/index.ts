import axios from 'axios'
import QuestApi from './services/quest/quest'
import SharedApi from './services/shared/shared'
import { RequestErrorInterceptor } from './interceptors/request-error'

const instance = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
})

RequestErrorInterceptor(instance)

export const api = {
  shared: SharedApi(instance),
  quest: QuestApi(instance),
}
