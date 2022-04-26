import LoansHistoryUser from '@/views/LoansHistoryUser.vue'
import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import SearchResult from '@/views/SearchResult.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/loans',
    name: 'loans',
    component: LoansHistoryUser
  },
  {
    path: '/search',
    name: 'searchView',
    component: SearchResult
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
