import Vue from 'vue'
import Router from 'vue-router'

import { Layout } from '@/layout'

export const constantRoutes = [
    {
        path: '/backstage',
        name: 'home',
        component: Layout
    },
]

export default new Router({
  mode: 'history',
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes
})
