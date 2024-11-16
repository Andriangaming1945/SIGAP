<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import axiosInstance from '../services/axiosInstance'
import { TransitionRoot } from '@headlessui/vue'
import Swal from 'sweetalert2'

// Form state management
const formData = reactive({
  name: '',
  email: '',
  tanggal_lahir: '',
  no_telp: '',
  Alamat: '',
  password: '',
  profile_image: null,
  age: '' // Added age field
})

// Error state management
const errors = reactive({
  name: '',
  email: '',
  tanggal_lahir: '',
  no_telp: '',
  Alamat: '',
  password: '',
  profile_image: '',
  age: '' // Added age error field
})

// UI state
const imagePreview = ref(null)
const loading = ref(false)
const router = useRouter()

// Validation rules matching Laravel backend
const validationRules = {
  name: (value) => {
    if (!value) return 'Name is required'
    if (value.length > 255) return 'Name must be less than 255 characters'
    return ''
  },
  email: (value) => {
    if (!value) return 'Email is required'
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return 'Please enter a valid email address'
    return ''
  },
  tanggal_lahir: (value) => {
    if (!value) return 'Date of birth is required'
    return ''
  },
  no_telp: (value) => {
    if (!value) return 'Phone number is required'
    if (!/^([0-9\s\-\+\(\)]*)$/.test(value)) return 'Please enter a valid phone number'
    if (value.length > 15) return 'Phone number must be less than 15 digits'
    return ''
  },
  Alamat: (value) => {
    if (!value) return 'Address is required'
    if (value.length > 255) return 'Address must be less than 255 characters'
    return ''
  },
  password: (value) => {
    if (!value) return 'Password is required'
    if (value.length < 8) return 'Password must be at least 8 characters'
    return ''
  },
  age: (value) => { // Added age validation
    if (!value) return 'Age is required'
    const numAge = parseInt(value)
    if (isNaN(numAge)) return 'Please enter a valid number'
    if (numAge < 0) return 'Age cannot be negative'
    if (numAge > 150) return 'Please enter a valid age'
    return ''
  }
}

// Image handling with proper validation
const handleImageUpload = (event) => {
  const file = event.target.files[0]
  if (!file) return

  // Validate file type
  const validTypes = ['image/jpeg', 'image/png', 'image/gif']
  if (!validTypes.includes(file.type)) {
    errors.profile_image = 'Please upload a valid image file (JPEG, PNG, or GIF)'
    return
  }

  // Validate file size (2MB)
  const maxSize = 2 * 1024 * 1024
  if (file.size > maxSize) {
    errors.profile_image = 'Image size should be less than 2MB'
    return
  }

  errors.profile_image = ''
  imagePreview.value = URL.createObjectURL(file)
  formData.profile_image = file
}

// Field validation
const validateField = (field) => {
  if (validationRules[field]) {
    errors[field] = validationRules[field](formData[field])
  }
}

// Form validation
const validateForm = () => {
  Object.keys(validationRules).forEach(validateField)
  return !Object.values(errors).some(error => error)
}

// Backend error handling
const handleBackendErrors = (responseErrors) => {
  Object.keys(responseErrors).forEach(field => {
    errors[field] = responseErrors[field][0]
  })
}

// Success message
const showSuccessMessage = async () => {
  await Swal.fire({
    title: 'Registration Successful!',
    text: 'Your account has been created successfully. Please login to continue.',
    icon: 'success',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading()
    },
    willClose: () => {
      router.push('/login')
    }
  })
}

// Error message with specific error details
const showErrorMessage = (message) => {
  Swal.fire({
    title: 'Registration Failed',
    text: message,
    icon: 'error',
    confirmButtonText: 'Try Again',
    confirmButtonColor: '#1e3a8a',
  })
}

// Form submission with proper error handling
const handleSubmit = async () => {
  if (!validateForm()) {
    showErrorMessage('Please fix the errors in the form.')
    return
  }
  
  loading.value = true
  try {
    const submitData = new FormData()
    Object.keys(formData).forEach(key => {
      if (formData[key] !== null) {
        submitData.append(key, formData[key])
      }
    })

    const response = await axiosInstance.post('/register', submitData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    
    if (response.data && response.data.message === 'Registration successful') {
      await showSuccessMessage()
    } else {
      throw new Error('Unexpected response format')
    }
  } catch (error) {
    console.error('Registration error:', error)
    
    if (error.response?.data?.errors) {
      handleBackendErrors(error.response.data.errors)
      showErrorMessage('Please check your input and try again.')
    } else if (error.response?.data?.message) {
      showErrorMessage(error.response.data.message)
    } else {
      showErrorMessage('An error occurred during registration. Please try again.')
    }
  } finally {
    loading.value = false
  }
}

const backToLogin = () => {
  router.push('/login')
}
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl flex overflow-hidden max-h-[990px]">
      <!-- Left Side - Form -->
      <div class="w-full md:w-1/2 p-6 overflow-y-auto">
        <!-- Logo and Title -->
        <div class="flex flex-col items-start mb-6">
          <div class="flex items-center mb-4">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-12">
              <path d="M24 4L44 16V32L24 44L4 32V16L24 4Z" stroke="#2563eb" stroke-width="2" fill="#EBF5FF"/>
              <path d="M24 8L40 18V30L24 40L8 30V18L24 8Z" stroke="#2563eb" stroke-width="2" fill="white"/>
              <rect x="16" y="22" width="16" height="12" fill="#2563eb"/>
              <rect x="20" y="26" width="8" height="8" fill="white"/>
            </svg>
            <div class="ml-3">
              <h1 class="text-3xl font-bold text-blue-900">SIGAP</h1>
              <p class="text-sm text-blue-900 font-medium tracking-wider">
                Sistem Integrasi dan Gerak<br />
                Antisipasi Penyakit
              </p>
            </div>
          </div>
        </div>

        <!-- Registration Form -->
        <form @submit.prevent="handleSubmit" class="space-y-4">
          <!-- Name Field -->
          <div class="form-group">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input
              v-model="formData.name"
              @blur="validateField('name')"
              type="text"
              id="name"
              :class="['form-input', errors.name ? 'error' : '']"
              placeholder="Enter your full name"
            />
            <TransitionRoot :show="!!errors.name">
              <p class="error-message">{{ errors.name }}</p>
            </TransitionRoot>
          </div>

          <!-- Email Field -->
          <div class="form-group">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
              v-model="formData.email"
              @blur="validateField('email')"
              type="email"
              id="email"
              :class="['form-input', errors.email ? 'error' : '']"
              placeholder="Enter your email address"
            />
            <TransitionRoot :show="!!errors.email">
              <p class="error-message">{{ errors.email }}</p>
            </TransitionRoot>
          </div>

          <!-- Date of Birth Field -->
          <div class="form-group">
            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
            <input
              v-model="formData.tanggal_lahir"
              @blur="validateField('tanggal_lahir')"
              type="date"
              id="tanggal_lahir"
              :class="['form-input', errors.tanggal_lahir ? 'error' : '']"
            />
            <TransitionRoot :show="!!errors.tanggal_lahir">
              <p class="error-message">{{ errors.tanggal_lahir }}</p>
            </TransitionRoot>
          </div>


          <div class="form-group">
  <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Umur</label>
  <input
    type="text"
    v-model="formData.age"
    @blur="validateField('age')"
    id="age"
    :class="['form-input w-24', errors.age ? 'error' : '']"
    placeholder="Umur"
    min="0"
    max="150"
  />
  <TransitionRoot :show="!!errors.age">
    <p class="error-message">{{ errors.age }}</p>
  </TransitionRoot>
</div>

          <!-- Phone Number Field -->
          <div class="form-group">
            <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
            <input
              v-model="formData.no_telp"
              @blur="validateField('no_telp')"
              type="tel"
              id="no_telp"
              :class="['form-input', errors.no_telp ? 'error' : '']"
              placeholder="Enter your phone number"
            />
            <TransitionRoot :show="!!errors.no_telp">
              <p class="error-message">{{ errors.no_telp }}</p>
            </TransitionRoot>
          </div>

          <!-- Address Field -->
          <div class="form-group">
            <label for="Alamat" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            <textarea
              v-model="formData.Alamat"
              @blur="validateField('Alamat')"
              id="Alamat"
              :class="['form-input', errors.alamat ? 'error' : '']"
              placeholder="Enter your address"
              rows="3"
            ></textarea>
            <TransitionRoot :show="!!errors.Alamat">
              <p class="error-message">{{ errors.Alamat }}</p>
            </TransitionRoot>
          </div>

          <!-- Password Fields -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-group">
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
              <input
                v-model="formData.password"
                @blur="validateField('password')"
                type="password"
                id="password"
                :class="['form-input', errors.password ? 'error' : '']"
                placeholder="Create a password"
              />
              <TransitionRoot :show="!!errors.password">
                <p class="error-message">{{ errors.password }}</p>
              </TransitionRoot>
            </div>

           
          </div>

          <!-- Profile Image Upload -->
          <div class="form-group">
            <label class="block text-sm font-medium text-gray-700 mb-1">Profile Image</label>
            <div class="flex items-center space-x-4">
              <label class="cursor-pointer inline-flex items-center px-4 py-2 border border-blue-900 rounded-md shadow-sm text-sm font-medium text-blue-900 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <input
                  type="file"
                  class="hidden"
                  accept="image/*"
                  @change="handleImageUpload"
                />
                Upload Image
              </label>
              <div v-if="imagePreview" class="relative w-16 h-16">
                <img
                  :src="imagePreview"
                  alt="Profile preview"
                  class="w-full h-full object-cover rounded-full"
                />
              </div>
            </div>
            <p class="mt-1 text-xs text-gray-500">PNG, JPG, JPEG Up to 2MB</p>
            <TransitionRoot :show="!!errors.profile_image">
              <p class="error-message">{{ errors.profile_image }}</p>
            </TransitionRoot>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="loading"
            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-900 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors duration-200"
          >
          <span v-if="loading" class="inline-flex items-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Registering...
            </span>
            <span v-else>Register</span>
          </button>

          <!-- Back to Login Button -->
          <button
            type="button"
            @click="backToLogin"
            class="w-full mt-4 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-blue-900 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
          >
            Back to Login
          </button>

          <!-- Footer -->
          <div class="mt-6 flex items-center justify-center space-x-2">
            <span class="text-gray-500 text-xs">© 2024 SIGAP. All rights reserved.</span>
          </div>
        </form>
      </div>

      <!-- Right Side - Image -->
      <div class="hidden md:block md:w-1/2 bg-blue-900 p-6">
        <div class="h-full flex items-center justify-center">
          <div class="relative w-full max-w-sm">
            <img
              src="/hospital.png"
              alt="Hospital Illustration"
              class="w-full h-auto object-contain"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.form-input {
  @apply w-full px-3 py-2 rounded-lg border border-gray-300 transition-all duration-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500;
}

.form-input.error {
  @apply border-red-500 focus:border-red-500 focus:ring-1 focus:ring-red-500;
}

.error-message {
  @apply mt-1 text-sm text-red-500 transition-all duration-300;
}

.form-group {
  @apply space-y-1;
}

/* Custom transitions */
.transition-enter-active,
.transition-leave-active {
  @apply transition-all duration-300;
}

.transition-enter-from,
.transition-leave-to {
  @apply opacity-0 -translate-y-1;
}

.transition-enter-to,
.transition-leave-from {
  @apply opacity-100 translate-y-0;
}

/* SweetAlert2 Custom Styles */
:deep(.swal2-popup) {
  @apply font-sans;
}

:deep(.swal2-title) {
  @apply text-blue-900 !important;
}

:deep(.swal2-icon.swal2-success) {
  @apply border-blue-900 text-blue-900 !important;
}

:deep(.swal2-icon.swal2-success [class^='swal2-success-line']) {
  @apply bg-blue-900 !important;
}

:deep(.swal2-icon.swal2-success .swal2-success-ring) {
  @apply border-blue-900/30 !important;
}

:deep(.swal2-timer-progress-bar) {
  @apply bg-blue-900 !important;
}

/* Responsive adjustments */

</style>