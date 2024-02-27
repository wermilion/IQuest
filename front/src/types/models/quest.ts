export interface Quest {
  id: number
  name: string
  short_description: string
  description: string
  cover: string
  min_people: number
  max_people: number
  duration: number
  imgaes?: []
  type: {
    id: number
    name: string
  }
  genre: {
    id: number
    name: string
  }
  age_limit?: {
    id: number
    name: string
  }
  level?: {
    id: number
    name: string
  }
  room?: {
    id: number
    name: string
    filial: {
      id: number
      address: string
    }
  }
}
