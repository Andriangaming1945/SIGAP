// router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import ForgotPassword from '../views/ForgotPassword.vue'
import Passwordreset from '../views/Passwordreset.vue'
import Diabetes from '../views/Diabetes.vue'
import Jantung from '../views/Jantung.vue'
import Scanningfood from '../views/Scanningfood.vue'
import Stroke from '../views/Stroke.vue'
import ProfileUser from '../views/ProfileUser.vue'
import Tuberculosis from '../views/Tuberculosis.vue'
import AdminHome from '../views/AdminHome.vue'
import leukimia from '../views/leukimia.vue'
import Hipertensi from '../views/Hipertensi.vue'
const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },

  {
    path: '/admin',
    name: 'Admin',
    component: AdminHome,
    meta: { 
      requiresAuth: true,
      requiresAdmin: true
    }
  },

  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { guestOnly: true }
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: { guestOnly: true }
  },
  {
    path: '/forgot-password',
    name: 'Forgotpassword',
    component: ForgotPassword,
    meta: { guestOnly: true }
  },
  {
    path: '/resetpassword',
    name: 'Passwordreset',
    component: Passwordreset,
    meta: { guestOnly: true }
  },

  {
    path: '/diabetes',
    name: 'Diabetes',
    component: Diabetes
  },

  {
    path: '/jantung',
    name: 'Jantung',
    component: Jantung
  },

  {
    path: '/Stroke',
    name: 'Stroke',
    component: Stroke
  },

  {
    path: '/Scanning-food',
    name: 'Scanning',
    component: Scanningfood
  },

  {
    path: '/profileuser',
    name: 'ProfileUser',
    component: ProfileUser,
    meta: { requiresAuth: true }
  },


  {
    path: '/TBC',
    name: 'TBC',
    component: Tuberculosis
    
  },

  {
    path: '/Hipertensi',
    name: 'Hipertensi',
    component: Hipertensi
  },

  {
    path: '/leukimia',
    name: 'leukimia',
    component: leukimia
    
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  const user = JSON.parse(localStorage.getItem('user'))
  
  if (to.meta.requiresAuth && !token) {
    next('/login')
  } else if (to.meta.requiresAdmin && (!user || user.role !== 'admin')) {
    next('/')
  } else if (to.meta.guestOnly && token) {
    next('/')
  } else {
    next()
  }
})

export default router