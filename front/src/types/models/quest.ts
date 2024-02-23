export interface Quest {
  id: number
  name: string
  short_description?: string
  description?: string
  cover: string
  min_people?: number
  max_people?: number
  duration?: number
  type: {
    id: number
    name: string
  }
  genre?: {
    id: number
    name: string
  }
  room?: {
    id: number
    name: string
    filial: {
      id: number
      name: string
    }
  }
}
