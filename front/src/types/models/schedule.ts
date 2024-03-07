export interface Schedule {
  id: number
  quest: number
  date: Date
  timeslots: TimeSlots[]
}

export interface TimeSlots {
  id: number
  time: string
  price: number
  is_active: boolean
}
