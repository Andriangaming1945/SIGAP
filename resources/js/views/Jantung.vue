<template>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white p-4">
              <h2 class="text-center mb-0">
                <i class="bi bi-heart-pulse me-2"></i>
                Prediksi Penyakit Jantung 
              </h2>
            </div>
            
            <div class="card-body p-4">
              <form @submit.prevent="submitForm">
                <!-- Numeric Inputs -->
                <div class="row mb-4">
                  <div class="col-md-6 col-lg-3 mb-3">
                    <div class="form-floating">
                      <input 
                        v-model="inputData.age" 
                        type="number" 
                        class="form-control"
                        id="ageInput"
                        placeholder="Age"
                      />
                      <label for="ageInput">Age</label>
                    </div>
                  </div>
  
                  <div class="col-md-6 col-lg-3 mb-3">
                    <div class="form-floating">
                      <input 
                        v-model="inputData.blood_pressure" 
                        type="number"
                        class="form-control"
                        id="bpInput"
                        placeholder="Blood Pressure"
                      />
                      <label for="bpInput">Blood Pressure (mmHg)</label>
                    </div>
                  </div>
  
                  <div class="col-md-6 col-lg-3 mb-3">
                    <div class="form-floating">
                      <input 
                        v-model="inputData.cholesterol" 
                        type="number"
                        class="form-control"
                        id="cholesterolInput"
                        placeholder="Cholesterol"
                      />
                      <label for="cholesterolInput">Cholesterol (mg/dL)</label>
                    </div>
                  </div>
  
                  <div class="col-md-6 col-lg-3 mb-3">
                    <div class="form-floating">
                      <input 
                        v-model="inputData.heart_rate" 
                        type="number"
                        class="form-control"
                        id="heartRateInput"
                        placeholder="Heart Rate"
                      />
                      <label for="heartRateInput">Heart Rate (bpm)</label>
                    </div>
                  </div>
                </div>
  
                <!-- Risk Factors -->
                <div class="card mb-4 border-0 bg-light">
                  <div class="card-body">
                    <h5 class="card-title mb-3">Risk Factors</h5>
                    <div class="row g-3">
                      <div class="col-md-4">
                        <div class="form-check">
                          <input 
                            v-model="inputData.smoking" 
                            class="form-check-input"
                            type="checkbox" 
                            id="smoking"
                          />
                          <label class="form-check-label" for="smoking">
                            <i class="bi bi-emoji-neutral me-2"></i>Smoking
                          </label>
                        </div>
                      </div>
  
                      <div class="col-md-4">
                        <div class="form-check">
                          <input 
                            v-model="inputData.diabetes" 
                            class="form-check-input"
                            type="checkbox" 
                            id="diabetes"
                          />
                          <label class="form-check-label" for="diabetes">
                            <i class="bi bi-droplet me-2"></i>Diabetes
                          </label>
                        </div>
                      </div>
  
                      <div class="col-md-4">
                        <div class="form-check">
                          <input 
                            v-model="inputData.family_history" 
                            class="form-check-input"
                            type="checkbox" 
                            id="family_history"
                          />
                          <label class="form-check-label" for="family_history">
                            <i class="bi bi-people me-2"></i>Family History
                          </label>
                        </div>
                      </div>
  
                      <div class="col-md-4">
                        <div class="form-check">
                          <input 
                            v-model="inputData.physical_inactivity" 
                            class="form-check-input"
                            type="checkbox" 
                            id="physical_inactivity"
                          />
                          <label class="form-check-label" for="physical_inactivity">
                            <i class="bi bi-person-walking me-2"></i>Physical Inactivity
                          </label>
                        </div>
                      </div>
  
                      <div class="col-md-4">
                        <div class="form-check">
                          <input 
                            v-model="inputData.stress" 
                            class="form-check-input"
                            type="checkbox" 
                            id="stress"
                          />
                          <label class="form-check-label" for="stress">
                            <i class="bi bi-brain me-2"></i>Stress
                          </label>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-check">
                          <input 
                            v-model="inputData.anemia" 
                            class="form-check-input"
                            type="checkbox" 
                            id="anemia"
                          />
                          <label class="form-check-label" for="stress">
                            <i class="bi bi-brain me-2"></i>Anemia
                          </label>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-check">
                          <input 
                            v-model="inputData.cad" 
                            class="form-check-input"
                            type="checkbox" 
                            id="cad"
                          />
                          <label class="form-check-label" for="stress">
                            <i class="bi bi-brain me-2"></i>CAD
                          </label>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-check">
                          <input 
                            v-model="inputData.chf" 
                            class="form-check-input"
                            type="checkbox" 
                            id="chf"
                          />
                          <label class="form-check-label" for="stress">
                            <i class="bi bi-brain me-2"></i>CHF
                          </label>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-check">
                          <input 
                            v-model="inputData.pitting_edema" 
                            class="form-check-input"
                            type="checkbox" 
                            id="pitting_edema"
                          />
                          <label class="form-check-label" for="stress">
                            <i class="bi bi-brain me-2"></i>Pitting_edema
                          </label>
                        </div>
                      </div>
  
                      <div class="col-md-4">
                        <div class="form-check">
                          <input 
                            v-model="inputData.obesity" 
                            class="form-check-input"
                            type="checkbox" 
                            id="obesity"
                          />
                          <label class="form-check-label" for="obesity">
                            <i class="bi bi-person-plus me-2"></i>Obesity
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
  
                <!-- Submit Button -->
                <div class="d-grid gap-2 col-lg-6 mx-auto">
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-search-heart me-2"></i>
                    Analyze Risk
                  </button>
                </div>
              </form>
  
              <!-- Results Section -->
              <div v-if="predictionResult !== null" class="mt-4">
                <div class="alert alert-info">
                  <h4 class="alert-heading mb-3">
                    <i class="bi bi-clipboard2-pulse me-2"></i>
                    Assessment Results
                  </h4>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <h6 class="card-subtitle mb-2 text-muted">Prediction</h6>
                          <p :class="['h4', getPredictionClass]">
                            {{ predictionResult }}
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <h6 class="card-subtitle mb-2 text-muted">Risk Score</h6>
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
  import axiosInstance from '@/services/axiosInstance';
  
  export default {
    data() {
      return {
        inputData: {
          age: '',
          blood_pressure: '',
          cholesterol: '',
          heart_rate: '',
          smoking: false,
          diabetes: false,
          family_history: false,
          physical_inactivity: false,
          stress: false,
          obesity: false,
          cad: false,
          pitting_edema: false,
          anemia: false,
          chf: false
        },
        predictionResult: null,
        riskScore: null,
      };
    },
    computed: {
      getPredictionClass() {
        return {
          'text-danger': this.predictionResult?.toLowerCase().includes('high'),
          'text-warning': this.predictionResult?.toLowerCase().includes('moderate'),
          'text-success': this.predictionResult?.toLowerCase().includes('low'),
        };
      },
      getRiskClass() {
        if (!this.riskScore) return '';
        const score = parseFloat(this.riskScore);
        if (score >= 70) return 'text-danger';
        if (score >= 40) return 'text-warning';
        return 'text-success';
      },
    },
    methods: {
      async submitForm() {
        try {
          const response = await axiosInstance.post('/predict-heart-disease', this.inputData);
          this.predictionResult = response.data.prediction;
          this.riskScore = response.data.risk_score;
        } catch (error) {
          console.error('Error fetching prediction:', error);
          this.predictionResult = 'Error in fetching prediction';
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Custom styles to enhance Bootstrap */
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
  
  /* Animation for results */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  .alert {
    animation: fadeIn 0.5s ease-out;
  }
  </style>