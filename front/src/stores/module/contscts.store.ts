import type { Contact } from '#/types/models/contact'

//* --- State ----------------------------------------------- *//
interface ContactState {
  social: Contact[]
  phone: Contact[]
  emial: Contact[]
}

//* --- Store ----------------------------------------------- *//
export const useContactStore = defineStore('contact', {
  state: (): ContactState => ({
    social: [],
    phone: [],
    emial: [],
  }),
  getters: {
    requestWrapper: () => useRequestMeta().requestMetaWrapper,
    isLoading: (): boolean => useRequestMeta().checkAnyIsLoading(['contact']),
    errors: () => useRequestMeta().getError(['contact']),

  },
  actions: {
    async fetchSocial() {
      this.requestWrapper({
        key: 'contact',

        callback: () => {
          return api.contact.getContact({
            include: [
              'contactType',
            ],
            filter: {
              city_id: 1,
              contact_type_id: 1,
              is_social: true,
            },
          })
        },
        successCallback: ({ data }) => {
          this.social = data.data.data
        },
      })
    },
    async fetchPhone() {
      this.requestWrapper({
        key: 'contact',

        callback: () => {
          return api.contact.getContact({
            include: [
              'contactType',
            ],
            filter: {
              city_id: 1,
              contact_type_id: 3,
            },
          })
        },
        successCallback: ({ data }) => {
          this.phone = data.data.data
        },
      })
    },
    async fetchEmail() {
      this.requestWrapper({
        key: 'contact',

        callback: () => {
          return api.contact.getContact({
            include: [
              'contactType',
            ],
            filter: {
              city_id: 1,
              contact_type_id: 2,
            },
          })
        },
        successCallback: ({ data }) => {
          this.emial = data.data.data
        },
      })
    },
  },

})
