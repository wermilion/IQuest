export interface Schedule {
  id: number
  quest: number
  date: Date
  timeslots: [
    {
      id: number
      time: string
      price: string
      is_active: boolean
    },
  ]
}
