export interface SearchContactRequest {
  include: string[]
  filter: {
    city_id: number
    contact_type_id?: number
    is_social?: boolean
  }
}
