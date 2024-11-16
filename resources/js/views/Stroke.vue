<template>
    <div class="container my-5">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h3>Stroke Risk Prediction</h3>
        </div>
        <div class="card-body">
          <form @submit.prevent="submitForm">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" id="age" v-model="form.age" class="form-control" required />
              </div>
  
              <div class="col-md-6 mb-3">
                <label for="avg_glucose_level" class="form-label">Average Glucose Level</label>
                <input type="number" step="0.01" id="avg_glucose_level" v-model="form.avg_glucose_level" class="form-control" required />
              </div>
            </div>
  
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="hypertension" class="form-label">Hypertension</label>
                <select id="hypertension" v-model="form.hypertension" class="form-select" required>
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
                </select>
              </div>
  
              <div class="col-md-4 mb-3">
                <label for="heart_disease" class="form-label">Heart Disease</label>
                <select id="heart_disease" v-model="form.heart_disease" class="form-select" required>
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
                </select>
              </div>
  
              <div class="col-md-4 mb-3">
                <label for="smoking_status" class="form-label">Smoking Status</label>
                <select id="smoking_status" v-model="form.smoking_status" class="form-select" required>
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
                </select>
              </div>
            </div>
  
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="ac_near_face" class="form-label">AC Near Face</label>
                <select id="ac_near_face" v-model="form.ac_near_face" class="form-select" required>
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
                </select>
              </div>
  
              <div class="col-md-4 mb-3">
                <label for="head_injury" class="form-label">Head Injury</label>
                <select id="head_injury" v-model="form.head_injury" class="form-select" required>
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
                </select>
              </div>
  
              <div class="col-md-4 mb-3">
                <label for="diabetes" class="form-label">Diabetes</label>
                <select id="diabetes" v-model="form.diabetes" class="form-select" required>
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
                </select>
              </div>
            </div>
  
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="obesity" class="form-label">Obesity</label>
                <select id="obesity" v-model="form.obesity" class="form-select" required>
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
                </select>
              </div>
  
              <div class="col-md-6 mb-3">
                <label for="less_exposure_to_sunlight" class="form-label">Less Exposure to Sunlight</label>
                <select id="less_exposure_to_sunlight" v-model="form.less_exposure_to_sunlight" class="form-select" required>
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
                </select>
              </div>
            </div>
  
            <button type="submit" class="btn btn-primary">Predict Risk</button>
          </form>
  
          <div v-if="predictionResult" class="alert mt-4" :class="{'alert-danger': predictionResult.prediction === 'High Risk', 'alert-success': predictionResult.prediction === 'Low Risk'}">
            <h4>{{ predictionResult.prediction }}</h4>
            <p>Risk Score: {{ predictionResult.risk_score }}</p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axiosInstance from "@/services/axiosInstance";
  
  export default {
    data() {
      return {
        form: {
          age: "",
          hypertension: false,
          heart_disease: false,
          avg_glucose_level: "",
          smoking_status: false,
          ac_near_face: false,
          head_injury: false,
          diabetes: false,
          obesity: false,
          less_exposure_to_sunlight: false,
        },
        predictionResult: null,
      };
    },
    methods: {
      async submitForm() {
        try {
          const response = await axiosInstance.post("/predict-stroke", this.form);
          this.predictionResult = response.data;
        } catch (error) {
          console.error("Error predicting stroke risk:", error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Custom styling if needed */
  .card {
    border-radius: 10px;
  }
  
  .btn-primary {
    width: 100%;
  }
  
  .alert {
    text-align: center;
  }
  </style>
  