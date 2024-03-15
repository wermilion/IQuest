import type { Filial } from '#/types/models/filial'

//* --- State ----------------------------------------------- *//
interface FilialListState {
  filialList: Filial[]
}

//* --- Store ----------------------------------------------- *//
export const useFilialListStore = defineStore('filialList', {
  state: (): FilialListState => ({
    filialList: [],
  }),
  getters: {

    requestWrapper: () => useRequestMeta().requestMetaWrapper,
    isLoading: (): boolean => useRequestMeta().checkAnyIsLoading(['lounge']),
    errors: () => useRequestMeta().getError(['lounge']),

    getFirstFilial: state => state.filialList[0],
    getFirstRoom: state => state.filialList[0]?.lounges[0],
  },
  actions: {
    async fetchFilial() {
      const stores = setupStore(['city'])
      this.requestWrapper({
        key: 'lounge',

        callback: () => {
          return api.filial.getFilialList({
            include: [
              'city',
              'lounges',
            ],
            filter: {
              city_id: stores.city.selectedCity.id,
              lounge_is_active: true,
            },
          })
        },
        successCallback: ({ data }) => {
          this.filialList = data.data.data
        },
      })
    },
  },

})
