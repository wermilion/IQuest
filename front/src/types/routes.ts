export enum EAppRouteNames {
  Home = 'Quests',
  Quest = 'Quest',
  Contacts = 'Contacts',
  Certificates = 'Certificates',
  Holidays = 'Holidays',
  Lounge = 'Lounge',
  NotFound = 'NotFound',
}

export enum EAppRoutePaths {
  Home = '/',
  Quest = '/quest/:id',
  Contacts = '/contacts',
  Certificates = '/certificates',
  Holidays = '/holidays/:id',
  Lounge = '/lounge',
  NotFound = '/:pathMatch(.*)*',
}
