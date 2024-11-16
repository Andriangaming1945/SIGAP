<template>
  <div class="max-w-2xl mx-auto p-4">
    <form @submit.prevent="submitForm" class="space-y-4">
      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nama Pasien</label>
        <input 
          v-model="formData.nama_pasien"
          type="text"
          class="w-full p-2 border rounded"
          placeholder="Masukkan nama pasien"
          required
        />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">
          Sel Darah Putih 
          <span class="text-gray-500 text-sm">(contoh: 4500)</span>
        </label>
        <input 
          v-model="formData.sel_darah_putih"
          type="text"
          class="w-full p-2 border rounded"
          placeholder="Masukkan jumlah sel darah putih"
          @input="handleNumericInput('sel_darah_putih')"
          required
        />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">
          Hemoglobin 
          <span class="text-gray-500 text-sm">(contoh: 12.5 atau 12)</span>
        </label>
        <input 
          v-model="formData.hemoglobin"
          type="text"
          class="w-full p-2 border rounded"
          placeholder="Masukkan nilai hemoglobin"
          @input="handleFlexibleNumberInput('hemoglobin')"
          required
        />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">
          Trombosit 
          <span class="text-gray-500 text-sm">(contoh: 150000)</span>
        </label>
        <input 
          v-model="formData.trombosit"
          type="text"
          class="w-full p-2 border rounded"
          placeholder="Masukkan jumlah trombosit"
          @input="handleNumericInput('trombosit')"
          required
        />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">
          Asam Urat 
          <span class="text-gray-500 text-sm">(contoh: 7.2 atau 7)</span>
        </label>
        <input 
          v-model="formData.asam_urat"
          type="text"
          class="w-full p-2 border rounded"
          placeholder="Masukkan nilai asam urat"
          @input="handleFlexibleNumberInput('asam_urat')"
          required
        />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">
          LDH 
          <span class="text-gray-500 text-sm">(contoh: 250.5 atau 250)</span>
        </label>
        <input 
          v-model="formData.ldh"
          type="text"
          class="w-full p-2 border rounded"
          placeholder="Masukkan nilai LDH"
          @input="handleFlexibleNumberInput('ldh')"
          required
        />
      </div>

      <button 
        type="submit" 
        class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600"
        :disabled="loading"
      >
        {{ loading ? 'Memproses...' : 'Prediksi' }}
      </button>
    </form>

    <!-- Results Section -->
    <div v-if="result" class="mt-6 p-4 border rounded bg-white shadow">
      <h3 class="text-lg font-semibold mb-2">Hasil Prediksi</h3>
      <div class="space-y-2">
        <div class="p-3 rounded" :class="getPredictionClass">
          <p class="font-bold">Prediksi: {{ getTranslatedPrediction }}</p>
          <p>Tingkat Risiko: {{ result.risk_score }}%</p>
        </div>
        
        <div class="mt-4 bg-gray-50 p-3 rounded">
          <h4 class="font-medium mb-2">Detail Hasil Tes:</h4>
          <ul class="space-y-1">
            <li>Nama Pasien: {{ result.blood_test.nama_pasien }}</li>
            <li>Sel Darah Putih: {{ formatNumber(result.blood_test.sel_darah_putih) }}</li>
            <li>Hemoglobin: {{ result.blood_test.hemoglobin }}</li>
            <li>Trombosit: {{ formatNumber(result.blood_test.trombosit) }}</li>
            <li>Asam Urat: {{ result.blood_test.asam_urat }}</li>
            <li>LDH: {{ result.blood_test.ldh }}</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Error Alert -->
    <div 
      v-if="error" 
      class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded"
    >
      {{ error }}
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'LeukemiaPredictionForm',
  data() {
    return {
      formData: {
        nama_pasien: '',
        sel_darah_putih: '',
        hemoglobin: '',
        trombosit: '',
        asam_urat: '',
        ldh: ''
      },
      loading: false,
      result: null,
      error: null
    };
  },
  computed: {
    getPredictionClass() {
      if (!this.result) return '';
      
      switch(this.result.prediction) {
        case 'Low Risk':
          return 'bg-green-100 text-green-800';
        case 'Medium Risk':
          return 'bg-yellow-100 text-yellow-800';
        case 'High Risk':
          return 'bg-red-100 text-red-800';
        default:
          return 'bg-gray-100';
      }
    },
    getTranslatedPrediction() {
      const translations = {
        'Low Risk': 'Risiko Rendah',
        'Medium Risk': 'Risiko Sedang',
        'High Risk': 'Risiko Tinggi'
      };
      return translations[this.result?.prediction] || this.result?.prediction;
    }
  },
  methods: {
    handleNumericInput(field) {
      // Hanya memperbolehkan angka
      this.formData[field] = this.formData[field].replace(/[^\d]/g, '');
    },
    handleFlexibleNumberInput(field) {
      let value = this.formData[field];
      
      // Bersihkan input, hanya ijinkan angka dan satu titik desimal
      value = value.replace(/[^\d.]/g, '');
      
      // Tangani multiple dots
      const parts = value.split('.');
      if (parts.length > 2) {
        value = parts[0] + '.' + parts.slice(1).join('');
      }
      
      this.formData[field] = value;
    },
    formatDataBeforeSubmit() {
      const formattedData = { ...this.formData };
      
      // Konversi string ke tipe data yang sesuai
      formattedData.sel_darah_putih = parseInt(this.formData.sel_darah_putih) || 0;
      formattedData.trombosit = parseInt(this.formData.trombosit) || 0;
      
      // Format angka desimal
      ['hemoglobin', 'asam_urat', 'ldh'].forEach(field => {
        let value = this.formData[field];
        if (value.includes('.')) {
          // Jika ada desimal, format ke 2 angka desimal
          formattedData[field] = parseFloat(value).toFixed(2);
        } else {
          // Jika tidak ada desimal, tambahkan .00
          formattedData[field] = parseFloat(value).toFixed(2);
        }
      });

      return formattedData;
    },
    formatNumber(num) {
      return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    async submitForm() {
      this.loading = true;
      this.error = null;
      this.result = null;

      try {
        const formattedData = this.formatDataBeforeSubmit();
        const response = await axios.post('/api/prediksi-leukemia', formattedData);
        this.result = response.data;
        
        if (response.data.message === 'Data berhasil disimpan!') {
          this.formData = {
            nama_pasien: '',
            sel_darah_putih: '',
            hemoglobin: '',
            trombosit: '',
            asam_urat: '',
            ldh: ''
          };
        }
      } catch (error) {
        this.error = 'Mohon periksa kembali data yang diinput';
        console.error('Error:', error);
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>