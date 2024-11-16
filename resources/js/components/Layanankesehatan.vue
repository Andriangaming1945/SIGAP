<template>
  <div class="bg-gray-100 py-12">
    <div class="container mx-auto">
      <!-- Kontainer Bootstrap -->
      <div class="container" v-if="isLoggedIn">
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <!-- Card 1 -->
          <div class="col">
            <div class="card shadow-sm">
              <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                  <div class="bg-indigo-500 p-3 rounded-circle mr-3">
                    <template-icon class="text-white h-6 w-6" />
                  </div>
                  <h5 class="card-title text-gray-800 font-bold">Prediksi Diabetes</h5>
                </div>
                <img src="images/Diabetes.jpg" alt="Prediksi Diabetes" class="card-img-top mb-4 rounded" />
                <router-link to="/diabetes" class="btn btn-primary w-100">
                  Mulai Prediksi !
                </router-link>
              </div>  
            </div>
          </div>

          <!-- Card 2 -->
     
        



          <!-- Card 6 - Entrees Scanner -->
          <div class="col">
            <div class="card shadow-sm">
              <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                  <div class="bg-indigo-500 p-3 rounded-circle mr-3">
                    <policy-icon class="text-white h-6 w-6" />
                  </div>
                  <h5 class="card-title text-gray-800 font-bold">Entrees Scanner</h5>
                </div>
                <img src="images/gradient.webp" alt="Peraturan Kerja Sama" class="card-img-top mb-4 rounded" />
                <router-link to="/Scanning-food" class="btn btn-primary w-100">
                  Mulai scanning !
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Login reminder -->
      <div v-else class="bg-white shadow-md rounded-lg p-6 text-center">
        <h3 class="text-gray-800 font-bold text-xl mb-4">Oops!</h3>
        <p class="text-gray-600 mb-6">Anda harus login terlebih dahulu untuk mengakses layanan kesehatan.</p>
        <router-link to="/login" class="btn btn-primary">
          Login
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isLoggedIn: false
    }
  },
  created() {
    this.checkLogin();
  },
  methods: {
    checkLogin() {
      const token = localStorage.getItem('token');
      this.isLoggedIn = !!token;
    }
  }
}
</script>

<style scoped>
/* Optional: Adjust the height of the image */
.card-img-top {
  object-fit: cover;
  height: 200px;
}

.card-body {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
</style>