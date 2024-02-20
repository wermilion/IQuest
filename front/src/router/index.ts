import type { NavigationGuardNext, RouteLocationNormalized, RouteRecordRaw, Router } from 'vue-router'
import { createRouter, createWebHistory } from 'vue-router'
import { nextTick } from 'vue'
import { EAppRouteNames, EAppRoutePaths } from '#/types/routes'

import { useGlobalStore } from '#/stores/common/global.store'

const Quests = () => import('#/views/quests-view.vue')

const routes: RouteRecordRaw[] = [
  {
    path: EAppRoutePaths.Quests,
    name: EAppRouteNames.Quests,
    component: Quests,
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
