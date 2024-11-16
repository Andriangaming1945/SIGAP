<template>
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-20">
          <div class="flex items-center flex-shrink-0">
            <router-link to="/" class="flex items-center">
              <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-12">
                <path d="M24 4L44 16V32L24 44L4 32V16L24 4Z" stroke="#2563eb" stroke-width="2" fill="#EBF5FF"/>
                <path d="M24 8L40 18V30L24 40L8 30V18L24 8Z" stroke="#2563eb" stroke-width="2" fill="white"/>
                <rect x="16" y="22" width="16" height="12" fill="#2563eb"/>
                <rect x="20" y="26" width="8" height="8" fill="white"/>
              </svg>
              <h2 class="ml-3 text-2xl font-bold text-blue-600 tracking-wide" style="font-size: 30px;">SIGAP</h2>
            </router-link>
          </div>
  
          <div class="hidden md:flex items-center justify-center flex-1 space-x-8">
            <router-link to="/" class="text-gray-600 hover:text-blue-600 transition-colors beranda-link">
              Beranda
            </router-link>
            <router-link to="/katalog" class="text-gray-600 hover:text-blue-600 transition-colors">
              About us
            </router-link>
            <router-link to="/masukan" class="text-gray-600 hover:text-blue-600 transition-colors">
              Layanan kesehatan
            </router-link>
            <router-link to="/profileuser" class="text-gray-600 hover:text-blue-600 transition-colors">
              Profile user
            </router-link>
            <router-link to="/faq" class="text-gray-600 hover:text-blue-600 transition-colors">
              Data statistik
            </router-link>
          </div>
  
          <div class="hidden md:flex items-center space-x-4">
            <template v-if="isLoggedIn">
              <div class="flex items-center space-x-4">
                <button 
                  @click="handleLogout" 
                  class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md transition-colors"
                >
                  Logout
                </button>
              </div>
            </template>
            <template v-else>
              <router-link 
                to="/login" 
                class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md transition-colors"
              >
                Login
              </router-link>
              <router-link 
                to="/register" 
                class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md transition-colors"
              >
                Register
              </router-link>
            </template>
          </div>
  
          <div class="md:hidden">
            <button 
              @click="toggleMobileMenu"
              class="text-gray-600 hover:text-blue-600 focus:outline-none"
            >
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path 
                  stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2" 
                  d="M4 6h16M4 12h16m-16 6h16"
                />
              </svg>
            </button>
          </div>
        </div>
  
        <div v-show="isMobileMenuOpen" class="md:hidden">
          <div class="px-2 pt-2 pb-3 space-y-1">
            <router-link
              to="/"
              class="block px-3 py-2 text-gray-600 hover:text-blue-600 transition-colors"
              @click="isMobileMenuOpen = false"
            >
              Beranda
            </router-link>
            <router-link
              to="/katalog"
              class="block px-3 py-2 text-gray-600 hover:text-blue-600 transition-colors"
              @click="isMobileMenuOpen = false"
            >
              Katalog Data
            </router-link>
            <router-link
              to="/masukan"
              class="block px-3 py-2 text-gray-600 hover:text-blue-600 transition-colors"
              @click="isMobileMenuOpen = false"
            >
              Masukan dan Pertanyaan
            </router-link>
            <router-link
              to="/faq"
              class="block px-3 py-2 text-gray-600 hover:text-blue-600 transition-colors"
              @click="isMobileMenuOpen = false"
            >
              FAQ
            </router-link>
            
            <template v-if="isLoggedIn">
              <div class="px-3 py-2 text-gray-600">Hello, {{ username }}</div>
              <button 
                @click="handleLogout"
                class="w-full text-left px-3 py-2 text-red-600 hover:text-red-700 transition-colors"
              >
                Logout
              </button>
            </template>
            <template v-else>
              <router-link
                to="/login"
                class="block px-3 py-2 text-blue-600 hover:text-blue-700 transition-colors"
                @click="isMobileMenuOpen = false"
              >
                Login
              </router-link>
              <router-link
                to="/register"
                class="block px-3 py-2 text-blue-600 hover:text-blue-700 transition-colors"
                @click="isMobileMenuOpen = false"
              >
                Register
              </router-link>
            </template>
          </div>
        </div>
      </div>
    </nav>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue'
  import { useRouter } from 'vue-router'
  import Swal from 'sweetalert2'
  
  const router = useRouter()
  const isMobileMenuOpen = ref(false)
  
  const token = computed(() => localStorage.getItem('token'))
  const user = computed(() => {
    try {
      return JSON.parse(localStorage.getItem('user'))
    } catch {
      return null
    }
  })
  
  const isLoggedIn = computed(() => !!token.value)
  const username = computed(() => user.value?.name || '')
  
  const handleLogout = async () => {
    try {
      const result = await Swal.fire({
        title: 'Konfirmasi Logout',
        text: 'Apakah anda yakin ingin keluar?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Keluar!',
        cancelButtonText: 'Batal'
      })
  
      if (result.isConfirmed) {
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        isMobileMenuOpen.value = false
        await router.push('/')
        
        // Tampilkan pesan sukses logout
        await Swal.fire({
          title: 'Berhasil Logout!',
          text: 'Anda telah berhasil keluar dari sistem',
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        })
        
        window.location.reload()
      }
    } catch (error) {
      console.error('Error during logout:', error)
      
     
      await Swal.fire({
        title: 'Error!',
        text: 'Terjadi kesalahan saat proses logout',
        icon: 'error',
        confirmButtonColor: '#2563eb'
      })
    }
  }

  
  
  const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value
  }
  </script>
  
  <style scoped>
  .router-link-active {
    color: #2563eb;
  }
  
  .transition-colors {
    transition: all 0.3s ease;
  }
  

  a {
    text-decoration: none;
  }
  
  a:hover {
    text-decoration: none;
    color: #2563eb;
  }
  

 
  </style>
  