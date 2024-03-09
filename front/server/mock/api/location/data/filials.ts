import { faker } from '@faker-js/faker'
import type { Filials } from '../location.types'

export function filials(): Filials {
  return {
    id: faker.number.int({ min: 10, max: 1000 }),
    yandex_mark: 'Метка',
    address: faker.location.street(),
    city: {
      id: faker.number.int({ min: 10, max: 1000 }),
      name: faker.location.city(),
    },
    lounges: Array.from({ length: faker.number.int({ min: 1, max: 3 }) }, () => ({
      id: faker.number.int({ min: 10, max: 1000 }),
      max_people: faker.number.int({ min: 1, max: 10 }),
      name: faker.lorem.word(),
      price_per_half_hour: faker.commerce.price(),
      price_per_hour: faker.commerce.price(),
      cover: faker.image.urlLoremFlickr({ category: 'cat' }),
      description: faker.lorem.words({ min: 1, max: 10 }),
    })),
  }
}
