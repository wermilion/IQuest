import type { NavigationGuardNext, RouteLocationNormalized, RouteRecordRaw, Router } from 'vue-router'
import { createRouter, createWebHistory } from 'vue-router'
import { nextTick } from 'vue'
import { EAppRouteNames, EAppRoutePaths } from '#/types/routes'

import { useGlobalStore } from '#/stores/common/global.store'

const Home = () => import('#/views/home.vue')
const Quest = () => import('#/views/quest.vue')
const Contacts = () => import('#/views/contacts.vue')

const routes: RouteRecordRaw[] = [
  {
    path: EAppRoutePaths.Home,
    name: EAppRouteNames.Home,
    component: Home,
  },
  {
    path: EAppRoutePaths.Quest,
    name: EAppRouteNames.Quest,
    component: Quest,
  },
  {
    path: EAppRoutePaths.Contacts,
    name: EAppRouteNames.Contacts,
    component: Contacts,
  },
]

const router: Router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(
  async (
    _to: RouteLocationNormalized,
    _from: RouteLocationNormalized,
    next: NavigationGuardNext,
  ) => {
    useGlobalStore().setLoading(true)
    await nextTick()
    next()
  },
)

router.afterEach(() => {
  useGlobalStore().setLoading(false)
})

export default router
