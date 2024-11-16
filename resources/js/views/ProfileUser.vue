<template>
  <div class="container mt-4">
    <!-- Loading State -->
    <div v-if="loading" class="text-center">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div v-else-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <div v-else>
      <!-- Header Profile -->
      <div class="card mb-3">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <i class="bi bi-person-circle me-2"></i>
            <span>My Profile</span>
          </div>
        </div>
      </div>

      <!-- Profile Banner -->
      <div class="card mb-4">
        <div class="card-body p-0">
          <div class="position-relative">
            <!-- Banner Background -->
            <div class="banner-background">
              <!-- Profile image position -->
              <div class="position-absolute" style="top: 50px; left: 50px;">
                <img :src="profileData.profile_image || '/default-avatar.png'" 
                     alt="Profile" 
                     class="rounded-circle border-4 border-white" 
                     style="width: 120px; height: 120px; object-fit: cover;">
              </div>
              <!-- Name and role section with change password -->
              <div class="position-absolute" style="top: 70px; left: 200px;">
                <h3 class="text-white mb-1">{{ profileData.name }}</h3>
                <p class="text-white-50 mb-1">Anggota</p>
                <p class="text-white-50 mb-0" style="font-size: 0.9em;">
                  <a href="#" class="btn btn-change-password" @click.prevent="changePassword">
                      Change Password
                    </a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Patient Details -->
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title mb-4">Pasien Details</h5>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nama</label>
              <input type="text" class="form-control" v-model="profileData.name" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tanggal Lahir</label>
              <input type="text" class="form-control" v-model="profileData.tanggal_lahir" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" v-model="profileData.email" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Alamat</label>
              <input type="text" class="form-control" v-model="profileData.Alamat" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">No. Handphone</label>
              <input type="text" class="form-control" v-model="profileData.no_telp" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Umur</label>
              <input type="text" class="form-control" v-model="profileData.age" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <HistoryPenyakit />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import HistoryPenyakit from '../components/HistoryPenyakit.vue';

const loading = ref(true)
const error = ref(null)
const profileData = ref({})
const selectedYear = ref('2024')

// Fetch profile data from API
const fetchProfile = async () => {
  try {
    const token = localStorage.getItem('token')
    if (!token) {
      throw new Error('No authentication token found')
    }

    const response = await axios.get('/api/profile', {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })

    if (response.data.success) {
      profileData.value = response.data.profile
    } else {
      throw new Error('Failed to fetch profile data')
    }
  } catch (err) {
    error.value = err.response?.data?.message || 'Error loading profile data'
  } finally {
    loading.value = false
  }
}

// Fetch data when component mounts
onMounted(() => {
  fetchProfile()
})
</script>

<style scoped>
.border-4 {
  border-width: 4px !important;
}

.table-dark {
  background-color: #1a237e;
}

.card {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-control:read-only {
  background-color: #f8f9fa;
}

.spinner-border {
  width: 3rem;
  height: 3rem;
}

.alert {
  padding: 15px;
  border-radius: 4px;
  margin-bottom: 20px;
}

/* Banner Background */
.banner-background {
  height: 200px;
  background-image: linear-gradient(
    rgba(25, 118, 210, 0.8),
    rgba(13, 71, 161, 0.9)
  ), url('/images/download.jpeg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Center Profile Image */
.profile-image-container {
  position: relative;
  top: 20px;
  transform: translateY(-50%);
  display: flex;
  justify-content: center;
}

/* Profile Information Centered */
.profile-info-container {
  text-align: center;
  margin-top: 60px;
}

/* Change Password Button Style */
.btn-change-password {
  background-color: rgba(255, 255, 255, 0.2);
  padding: 6px 12px;
  border-radius: 4px;
  text-decoration: none;
  color: white;
  font-size: 0.9em;
  transition: background-color 0.3s;
}

.btn-change-password:hover {
  background-color: rgba(255, 255, 255, 0.3);
}
</style>