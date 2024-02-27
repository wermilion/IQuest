export interface SearchQuestsRequest {
  include: string[]
  filter: {
    city: string
    is_active: boolean
  }
}
