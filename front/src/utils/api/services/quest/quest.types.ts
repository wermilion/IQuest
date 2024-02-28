export interface SearchQuestsRequest {
  include: string[]
  filter: {
    city: string
    is_active: boolean
  }
}

export interface SearchScheduleQuestsRequest {
  include: string[]
  filter: {
    quest: string | number
    today?: boolean
    tomorrow?: boolean
    weekend?: boolean
    between?: string[]
  }
}
