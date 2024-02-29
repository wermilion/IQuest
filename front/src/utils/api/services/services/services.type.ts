export interface SearchServicesRequest {
  include: string[]
  filter: {
    city: string
  }
}
