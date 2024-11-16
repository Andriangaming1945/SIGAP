<template>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white p-4">
              <h2 class="text-center mb-0">
                <i class="bi bi-heart-pulse me-2"></i>
                Prediksi Risiko Hipertensi
              </h2>
            </div>
  
            <div class="card-body p-4">
              <form @submit.prevent="submitForm">
                <!-- Symptoms -->
                <div class="row mb-4">
                  <div class="col-md-6 col-lg-3 mb-3">
                    <div class="form-check">
                      <input v-model="inputData.nyeri_dada" class="form-check-input" type="checkbox" id="nyeri_dada" />
                      <label class="form-check-label" for="nyeri_dada">Nyeri Dada</label>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 mb-3">
                    <div class="form-check">
                      <input v-model="inputData.sesak_nafas" class="form-check-input" type="checkbox" id="sesak_nafas" />
                      <label class="form-check-label" for="sesak_nafas">Sesak Nafas</label>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 mb-3">
                    <div class="form-check">
                      <input v-model="inputData.pusing" class="form-check-input" type="checkbox" id="pusing" />
                      <label class="form-check-label" for="pusing">Pusing</label>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 mb-3">
                    <div class="form-check">
                      <input v-model="inputData.mual" class="form-check-input" type="checkbox" id="mual" />
                      <label class="form-check-label" for="mual">Mual</label>
                    </div>
                  </div>
                </div>
  
                <div class="row mb-4">
                  <div class="col-md-6 col-lg-3 mb-3">
                    <div class="form-check">
                      <input v-model="inputData.kelelahan" class="form-check-input" type="checkbox" id="kelelahan" />
                      <label class="form-check-label" for="kelelahan">Kelelahan</label>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 mb-3">
                    <div class="form-check">
                      <input v-model="inputData.tekanan_darah_tinggi" class="form-check-input" type="checkbox" id="tekanan_darah_tinggi" />
                      <label class="form-check-label" for="tekanan_darah_tinggi">Tekanan Darah Tinggi</label>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3 mb-3">
                    <div class="form-check">
                      <input v-model="inputData.riwayat_hipertensi" class="form-check-input" type="checkbox" id="riwayat_hipertensi" />
                      <label class="form-check-label" for="riwayat_hipertensi">Riwayat Hipertensi</label>
                    </div>
                  </div>
                </div>
  
                <!-- Submit Button -->
                <div class="d-grid gap-2 col-lg-6 mx-auto">
                  <button :disabled="isFormEmpty" type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-search-heart me-2"></i>
                    Analisis Risiko
                  </button>
                </div>
              </form>
  
              <!-- Results Section -->
              <div v-if="predictionResult !== null" class="mt-4">
                <div class="alert alert-info">
                  <h4 class="alert-heading mb-3">
                    <i class="bi bi-clipboard2-pulse me-2"></i>
                    Hasil Prediksi
                  </h4>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <h6 class="card-subtitle mb-2 text-muted">Prediksi</h6>
                          <p :class="['h4', getPredictionClass]">
                            {{ predictionResult }}
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <h6 class="card-subtitle mb-2 text-muted">Skor Risiko</h6>
                          <p :class="['h4', getRiskClass]">
                            {{ riskScore }}%
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        inputData: {
          nyeri_dada: false,
          sesak_nafas: false,
          pusing: false,
          mual: false,
          kelelahan: false,
          tekanan_darah_tinggi: false,
          riwayat_hipertensi: false,
        },
        predictionResult: null,
        riskScore: null,
      };
    },
    computed: {
      getPredictionClass() {
        return {
          'text-danger': this.predictionResult === 'High Risk',
          'text-warning': this.predictionResult === 'Medium Risk',
          'text-success': this.predictionResult === 'Low Risk',
        };
      },
      getRiskClass() {
        if (this.riskScore >= 75) return 'text-danger';
        if (this.riskScore >= 25) return 'text-warning';
        return 'text-success';
      },
      isFormEmpty() {
        return !Object.values(this.inputData).some(value => value);
      },
    },
    methods: {
      async submitForm() {
        try {
          const response = await axios.post('/api/predic-hipertensi', this.inputData);
          this.predictionResult = response.data.prediction;
          this.riskScore = response.data.risk_score;
        } catch (error) {
          console.error('Error submitting form:', error);
        }
      },
    },
  };
  </script>
  