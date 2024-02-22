import type { NavigationGuardNext, RouteLocationNormalized, RouteRecordRaw, Router } from 'vue-router'
import { createRouter, createWebHistory } from 'vue-router'
import { nextTick } from 'vue'
import { EAppRouteNames, EAppRoutePaths } from '#/types/routes'

import { useGlobalStore } from '#/stores/common/global.store'

const QuestsHome = () => import('#/views/quests-view.vue')
const QuestCard = () => import('#/views/quest-view.vue')
const Contacts = () => import('#/views/contacts-view.vue')

const routes: RouteRecordRaw[] = [
  {
    path: EAppRoutePaths.QuestsHome,
    name: EAppRouteNames.QuestsHome,
    component: QuestsHome,
  },
  {
    path: EAppRoutePaths.QuestCard,
    name: EAppRouteNames.QuestCard,
    component: QuestCard,
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
