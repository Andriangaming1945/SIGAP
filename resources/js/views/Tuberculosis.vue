<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-lg border-0">
          <div class="card-header bg-primary text-white p-4">
            <h2 class="text-center mb-0">
              <i class="bi bi-heart-pulse me-2"></i>
              Prediksi Risiko TBC
            </h2>
          </div>

          <div class="card-body p-4">
            <form @submit.prevent="submitForm">
              <!-- Symptoms -->
              <div class="row mb-4">
                <div class="col-md-6 col-lg-3 mb-3">
                  <div class="form-check">
                    <input v-model="inputData.batuk" class="form-check-input" type="checkbox" id="batuk" />
                    <label class="form-check-label" for="batuk">Batuk lebih dari 2 minggu</label>
                  </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                  <div class="form-check">
                    <input v-model="inputData.batuk_berdarah" class="form-check-input" type="checkbox" id="batuk_berdarah" />
                    <label class="form-check-label" for="batuk_berdarah">Batuk Berdarah</label>
                  </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                  <div class="form-check">
                    <input v-model="inputData.demam" class="form-check-input" type="checkbox" id="demam" />
                    <label class="form-check-label" for="demam">Demam</label>
                  </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                  <div class="form-check">
                    <input v-model="inputData.keringat_malam" class="form-check-input" type="checkbox" id="keringat_malam" />
                    <label class="form-check-label" for="keringat_malam">Keringat Malam</label>
                  </div>
                </div>
              </div>

              <!-- Risk Factors -->
              <div class="row mb-4">
                <div class="col-md-6 col-lg-3 mb-3">
                  <div class="form-check">
                    <input v-model="inputData.penurunan_berat_badan" class="form-check-input" type="checkbox" id="penurunan_berat_badan" />
                    <label class="form-check-label" for="penurunan_berat_badan">Penurunan Berat Badan</label>
                  </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                  <div class="form-check">
                    <input v-model="inputData.kelelahan" class="form-check-input" type="checkbox" id="kelelahan" />
                    <label class="form-check-label" for="kelelahan">Kelelahan</label>
                  </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                  <div class="form-check">
                    <input v-model="inputData.kontak_tbc" class="form-check-input" type="checkbox" id="kontak_tbc" />
                    <label class="form-check-label" for="kontak_tbc">Kontak dengan penderita TBC</label>
                  </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-3">
                  <div class="form-check">
                    <input v-model="inputData.perjalanan_tbc_endemic" class="form-check-input" type="checkbox" id="perjalanan_tbc_endemic" />
                    <label class="form-check-label" for="perjalanan_tbc_endemic">Perjalanan ke daerah endemis TBC</label>
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
                  Hasil Penilaian
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
        batuk: false,
        batuk_berdarah: false,
        demam: false,
        keringat_malam: false,
        penurunan_berat_badan: false,
        kelelahan: false,
        kontak_tbc: false,
        perjalanan_tbc_endemic: false,
      },
      predictionResult: null,
      riskScore: null,
    };
  },
  computed: {
    getPredictionClass() {
      return {
        'text-danger': this.predictionResult === 'High Risk',
        'text-success': this.predictionResult === 'Low Risk',
      };
    },
    getRiskClass() {
      if (this.riskScore >= 50) return 'text-danger';
      return 'text-success';
    },
    isFormEmpty() {
      return !Object.values(this.inputData).some(value => value);
    },
  },
  methods: {
    async submitForm() {
      try {
        const response = await axios.post('/api/predict-tbc', this.inputData);
        this.predictionResult = response.data.prediction;
        this.riskScore = response.data.risk_score;
      } catch (error) {
        console.error('Error submitting form:', error);
      }
    },
  },
};
</script>