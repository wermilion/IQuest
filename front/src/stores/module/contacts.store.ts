import type { Contact } from '#/types/models/contact'

//* --- State ----------------------------------------------- *//
interface ContactState {
  social: Contact[]
}

//* --- Store ----------------------------------------------- *//
export const useContactStore = defineStore('contact', {
  state: (): ContactState => ({
    social: [],
  }),
  getters: {
    requestWrapper: () => useRequestMeta().requestMetaWrapper,
    isLoading: (): boolean => useRequestMeta().checkAnyIsLoading(['contact']),
    errors: () => useRequestMeta().getError(['contact']),

    getPhone: (state) => {
      const phone = state.social.find(item => item.type.name === 'Номер телефона')
      return phone ? phone.value : null
    },

    getEmail: (state) => {
      const email = state.social.find(item => item.type.name === 'Почта')
      return email ? email.value : null
    },

    getSocial: (state) => {
      const social = state.social.filter(item => item.type.is_social === true)
      return social.length > 0 ? social : null
    },

  },
  actions: {
    async fetchContact() {
      const stores = setupStore(['city'])
      this.requestWrapper({
        key: 'contact',

        callback: () => {
          return api.contact.getContact({
            include: [
              'contactType',
            ],
            filter: {
              city_id: stores.city.selectedCity.id,
            },
          })
        },
        successCallback: ({ data }) => {
          this.social = data.data.data
        },
      })
    },
  },

})
