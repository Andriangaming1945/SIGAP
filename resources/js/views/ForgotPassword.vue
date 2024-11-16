<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const formData = ref({
  name: '',
  email: '',
  code: ''
})

const router = useRouter()

const handleSendCode = () => {
  console.log('Sending code for:', formData.value)
}

const handleLogin = () => {
  console.log('Logging in with:', formData.value)
  router.push('/resetpassword')
}

const backToLogin = () => {
  router.push('/login')
}
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl flex overflow-hidden max-h-[800px]">
      <!-- Left Login Form Section -->
      <div class="w-full md:w-1/2 p-6">
        <div class="flex flex-col items-start mb-6">
          <div class="flex flex-col items-start mb-4">
            <RouterLink to="/">
              <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-12">
                <!-- Logo SIGAP - Simplified Building/Institution Icon -->
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

        <form class="space-y-4">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input
              id="name"
              v-model="formData.name"
              type="text"
              class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
              placeholder="Nama"
            />
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              id="email"
              v-model="formData.email"
              type="email"
              class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
              placeholder="Email"
            />
          </div>

          <button
            type="button"
            @click="handleSendCode"
            class="w-full bg-blue-400 text-white py-2 rounded-lg hover:bg-blue-600 active:bg-blue-700 transition-colors text-sm"
          >
            Send
          </button>

          <div>
            <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
            <input
              id="code"
              v-model="formData.code"
              type="text"
              class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
              placeholder="Code"
            />
          </div>

          <button
            type="button"
            @click="handleLogin"
            class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-950 transition-colors text-sm"
          >
            Go!
          </button>
        </form>

        <button
          @click="backToLogin"
          class="w-full mt-4 text-center inline-block bg-gray-200 py-2 rounded-lg text-blue-900 hover:bg-gray-300 hover:text-blue-950 transition-colors text-sm"
        >
          Back to Login
        </button>

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
