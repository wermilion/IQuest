import { useGlobalStore } from './common/global.store'
import { useQuestStore } from './module/quest.store'
import { useQuestListStore } from './module/quest-list.store'
import { useScheduleQuestStore } from './module/schedule.store'
import { useChipStore } from './common/booking.store'
import { useStocksStore } from './module/stocks.store'

type ExtractStoreId<T> = T extends { $id: infer U } ? U : never

interface IStoreTypes {
  global: ReturnType<typeof useGlobalStore>
  quest: ReturnType<typeof useQuestStore>
  questList: ReturnType<typeof useQuestListStore>
  scheduleQuest: ReturnType<typeof useScheduleQuestStore>
  chip: ReturnType<typeof useChipStore>
  stocks: ReturnType<typeof useStocksStore>
}

type StoreKeys = ExtractStoreId<IStoreTypes[keyof IStoreTypes]>

export const stores: Readonly<{ [K in StoreKeys]: () => IStoreTypes[K] }> = Object.freeze({
  global: useGlobalStore,
  quest: useQuestStore,
  questList: useQuestListStore,
  scheduleQuest: useScheduleQuestStore,
  chip: useChipStore,
  stocks: useStocksStore,
})

function setupStore<T extends StoreKeys>(key: T): Readonly<IStoreTypes[T]>
function setupStore<T extends StoreKeys>(keys: T[]): Readonly<{ [K in T]: IStoreTypes[K]; }>
function setupStore<T extends StoreKeys>(keysOrKey: T[] | T) {
  if (Array.isArray(keysOrKey))
    return Object.fromEntries(keysOrKey.map(key => [key, stores[key]()])) as { [K in T]: IStoreTypes[K] }

  return stores[keysOrKey]()
}

export { setupStore }
