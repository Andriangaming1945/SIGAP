<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axiosInstance from '../services/axiosInstance'
import Swal from 'sweetalert2' 

const formData = ref({
  email: '',
  password: '',
  keepLoggedIn: false
})

const router = useRouter()
const error = ref('')

const showSuccessAlert = (role) => {
  return Swal.fire({
    title: 'Login Berhasil!',
    text: `Anda akan diarahkan ke halaman ${role === 'admin' ? 'admin' : 'utama'}`,
    icon: 'success',
    showConfirmButton: false,
    timer: 1500,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading()
    }
  })
}

const handleLogin = async () => {
  try {
    const response = await axiosInstance.post('/login', {
      email: formData.value.email,
      password: formData.value.password
    })

    // Store token
    localStorage.setItem('token', response.data.token)
    
    // Store user data
    localStorage.setItem('user', JSON.stringify(response.data.user))

    // Set authorization header
    axiosInstance.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`

    // Show success alert
    await showSuccessAlert(response.data.user.role)
    
    // Redirect based on user role
    if (response.data.user.role === 'admin') {
      router.push('/admin')
    } else {
      router.push('/')
    }
  } catch (err) {
    if (err.response?.data?.errors?.email) {
      error.value = err.response.data.errors.email[0]
    } else {
      error.value = 'Login failed. Please try again.'
    }
  }
}
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl flex overflow-hidden max-h-[660px]">
      <!-- Left Login Form Section -->
      <div class="w-full md:w-1/2 p-6">
        <div class="flex flex-col items-start mb-6">
          <div class="flex flex-col items-start mb-4">
            <RouterLink to="/">
              <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-12">
                <path d="M24 4L44 16V32L24 44L4 32V16L24 4Z" stroke="#2563eb" stroke-width="2" fill="#EBF5FF"/>
                <path d="M24 8L40 18V30L24 40L8 30V18L24 8Z" stroke="#2563eb" stroke-width="2" fill="white"/>
                <rect x="16" y="22" width="16" height="12" fill="#2563eb"/>
                <rect x="20" y="26" width="8" height="8" fill="white"/>
              </svg>
            </RouterLink>
            <h1 class="text-5xl font-bold text-blue-900 mb-1" style="padding-left: 14px; padding-top: 15px;">SIGAP</h1>
            <p class="text-gray-600 mb-3 text-sm" style="font-family: Montserrat; font-weight: 500; line-height: 24px; letter-spacing: 0.2em; text-align: left; padding-left: 16px; font-size: 20px; color: rgb(30 58 138);">
              Sistem Integrasi dan Gerak <br>Antisipasi Penyakit
            </p>
          </div>
        </div>

        <p class="text-xs text-gray-500 mb-4" style="padding-bottom: 10px;">
          Log in with your data that you entered during <br>registration.
        </p>

        <!-- Show error message if exists -->
        <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
          {{ error }}
        </div>

        <form class="space-y-4" @submit.prevent="handleLogin">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
              v-model="formData.email"
              type="text"
              id="email"
              class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
              placeholder="Email"
            />
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
              v-model="formData.password"
              type="password"
              id="password"
              class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
              placeholder="Password"
            />
          </div>

          <div class="flex items-center" style="padding-left: 18px;">
            <input
              v-model="formData.keepLoggedIn"
              type="checkbox"
              id="keep-logged-in"
              class="rounded border-gray-300 text-blue-600"
            />
            <label for="keep-logged-in" class="ml-2 text-xs text-gray-600">
              Keep me logged in
            </label>
          </div>

          <button
            type="submit"
            class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-950 transition-colors text-sm"
          >
            Log in
          </button>
        </form>

        <div class="flex justify-between mt-6 text-xs" style="font-size: 15px;">
          <RouterLink to="/forgot-password" class="text-black-600 hover:underline" style="padding-left: 20px;">Forgot password?</RouterLink>
          <RouterLink to="/register" class="text-black-600 hover:underline" style="padding-right: 30px;">Registerasi</RouterLink>
        </div>

        <div class="mt-6 flex items-center justify-center space-x-1">
          <span class="text-gray-500 text-xs">Copyright</span>
          <img src="/logo.svg" alt="Logo" class="h-10" />
        </div>
      </div>

      <!-- Right Illustration Section -->
      <div class="hidden md:block md:w-1/2 bg-blue-900 p-6">
        <div class="h-full flex items-center justify-center">
          <div class="relative w-full max-w-sm">
            <img
              src="/hospital.png"
              alt="Hospital Illustration"
              class="w-full"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>