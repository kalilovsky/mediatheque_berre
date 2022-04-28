import LoansHistoryUser from '@/views/LoansHistoryUser.vue'
import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import SearchResult from '@/views/SearchResult.vue'
import AdminDashboardView from '@/views/AdminDashboardView.vue'
import HomeDashboardAdmin from '@/views/HomeDashboardAdmin.vue'
import AdminAllUsers from '@/views/AdminAllUsers.vue'
import AdminAllArticles from '@/views/AdminAllArticles.vue'
import AdminAllLoans from '@/views/AdminAllLoans.vue'
import AdminSettings from '@/views/AdminSettings.vue'

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
  {
    path: '/admindashboard',
    name: 'adminDashboard',
    component: AdminDashboardView,
    children:[
      {
        path:'',
        component:HomeDashboardAdmin
      },
      {
        path:'users',
        component: AdminAllUsers,
      },
      {
        path:'articles',
        component: AdminAllArticles,
      },
      {
        path:'loans',
        component: AdminAllLoans,
      },
      {
        path:'settings',
        component: AdminSettings,
      },
    ]
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
