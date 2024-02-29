export interface SearchStocksRequest {
  include: string[]
  filter: {
    city: string
    is_active: boolean
  }
}
