<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-lg border-0">
          <div class="card-header bg-primary text-white p-4">
            <h2 class="text-center mb-0">
              <i class="bi bi-heart-pulse me-2"></i>
              Prediksi Diabetes
            </h2>
          </div>
          
          <div class="card-body p-4">
            <form @submit.prevent="handleSubmit">
              <div class="row mb-4">
                <div class="col-md-6 mb-3">
                  <div class="form-floating">
                    <input
                      v-model="glucose"
                      type="number"
                      class="form-control"
                      id="glucose"
                      placeholder="Glukosa"
                      required
                    />
                    <label for="glucose">Glukosa</label>
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <div class="form-floating">
                    <input
                      v-model="bmi"
                      type="number"
                      class="form-control"
                      id="bmi"
                      placeholder="BMI"
                      required
                      step="0.01"
                    />
                    <label for="bmi">BMI</label>
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <div class="form-floating">
                    <input
                      v-model="age"
                      type="number"
                      class="form-control"
                      id="age"
                      placeholder="Usia"
                      required
                    />
                    <label for="age">Usia</label>
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <div class="form-floating">
                    <input
                      v-model="bloodPressure"
                      type="number"
                      class="form-control"
                      id="bloodPressure"
                      placeholder="Tekanan Darah"
                      required
                    />
                    <label for="bloodPressure">Tekanan Darah</label>
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <div class="form-floating">
                    <input
                      v-model="insulin"
                      type="number"
                      class="form-control"
                      id="insulin"
                      placeholder="Insulin"
                      required
                      step="0.01"
                    />
                    <label for="insulin">Insulin</label>
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <div class="form-floating">
                    <input
                      v-model="bodyThickness"
                      type="number"
                      class="form-control"
                      id="bodyThickness"
                      placeholder="Ketebalan Tubuh"
                      required
                      step="0.01"
                    />
                    <label for="bodyThickness">Ketebalan Tubuh (mm)</label>
                  </div>
                </div>
              </div>

              <div class="d-grid gap-2 col-lg-6 mx-auto">
                <button type="submit" class="btn btn-primary btn-lg">
                  <i class="bi bi-search-heart me-2"></i>
                  Submit
                </button>
              </div>
            </form>

            <div v-if="result" class="mt-4 alert alert-info">
              <h4 class="alert-heading mb-3">
                <i class="bi bi-clipboard2-pulse me-2"></i>
                Hasil Prediksi
              </h4>
              <p><strong>Prediksi:</strong> {{ result.prediction }}</p>
              <p><strong>Skor Risiko:</strong> {{ result.risk_score }}%</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/services/axiosInstance';

export default {
  data() {
    return {
      glucose: '',
      bmi: '',
      age: '',
      bloodPressure: '',
      insulin: '',
      bodyThickness: '',
      result: null,
    };
  },
  methods: {
    async handleSubmit() {
      try {
        const response = await axiosInstance.post('/predict-diabetes', {
          glucose: this.glucose,
          bmi: this.bmi,
          age: this.age,
          blood_pressure: this.bloodPressure,
          insulin: this.insulin,
          body_thickness: this.bodyThickness,
        });
        this.result = response.data;
      } catch (error) {
        console.error('Error saat mengirim prediksi:', error);
      }
    },
  },
};
</script>

<style scoped>
.card {
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-check-input:checked {
  background-color: #0d6efd;
  border-color: #0d6efd;
}

.btn-primary {
  transition: all 0.3s ease;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
}

.alert {
  animation: fadeIn 0.5s ease-out;
}
</style>
