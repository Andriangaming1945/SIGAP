<template>
  <div class="container mt-4">
    <!-- Status Section -->
    <div class="flex items-center gap-6 mb-8">
      <div class="w-24">
        <label class="text-gray-600 font-medium">Status</label>
      </div>
      <div class="w-48">
        <label class="block text-gray-600 font-medium mb-2">Tahun</label>
        <select 
          v-model="selectedYear" 
          class="w-full bg-white rounded-lg border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
          @change="loadData"
        >
          <option value="2024">2024</option>
          <option value="2023">2023</option>
        </select>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center min-h-[200px]">
      <div class="animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent"></div>
    </div>

    <div v-else class="space-y-8">
      <!-- Disease History Section -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6">
          <h5 class="text-2xl font-semibold text-center text-gray-800 mb-2">Histori Penyakit</h5>
          <p class="text-center text-gray-500 mb-6">Periode {{ selectedYear }}</p>
          
          <div v-if="error.diseases" class="bg-red-50 text-red-600 p-4 rounded-lg mb-4">
            {{ error.diseases }}
          </div>
          
          <div v-else-if="diseases.length === 0" class="text-center text-gray-500 py-8">
            Tidak ada data penyakit untuk tahun ini
          </div>
          
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-blue-700">
                  <th class="px-6 py-4 text-left text-sm font-semibold text-white tracking-wider w-1/5">
                    Penyakit
                  </th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-white tracking-wider w-1/5">
                    Status
                  </th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-white tracking-wider w-3/5">
                    Penjelasan
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                <tr 
                  v-for="disease in diseases" 
                  :key="disease.id"
                  class="hover:bg-gray-50 transition-colors duration-200"
                >
                  <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                    {{ disease.name }}
                  </td>
                  <td class="px-6 py-4">
                    <span 
                      :class="{
                        'px-3 py-1 text-sm font-medium rounded-full': true,
                        'bg-yellow-100 text-yellow-700': disease.status === 'Sedang',
                        'bg-red-100 text-red-700': disease.status === 'Gawat',
                        'bg-green-100 text-green-700': disease.status === 'Sembuh'
                      }"
                    >
                      {{ disease.status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600">
                    {{ disease.description }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Checkup History Section -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6">
          <h5 class="text-2xl font-semibold text-center text-gray-800 mb-2">Histori Check Up</h5>
          <p class="text-center text-gray-500 mb-6">Periode {{ selectedYear }}</p>
          
          <div v-if="error.checkups" class="bg-red-50 text-red-600 p-4 rounded-lg mb-4">
            {{ error.checkups }}
          </div>
          
          <div v-else-if="checkups.length === 0" class="text-center text-gray-500 py-8">
            Tidak ada data checkup untuk tahun ini
          </div>
          
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-blue-700">
                  <th class="px-6 py-4 text-left text-sm font-semibold text-white tracking-wider w-1/4">
                    Dokter
                  </th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-white tracking-wider w-1/4">
                    Tanggal
                  </th>
                  <th class="px-6 py-4 text-left text-sm font-semibold text-white tracking-wider w-2/4">
                    Rumah Sakit
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                <tr 
                  v-for="checkup in checkups" 
                  :key="checkup.id"
                  class="hover:bg-gray-50 transition-colors duration-200"
                >
                  <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                    {{ checkup.doctor }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600">
                    {{ checkup.date }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600">
                    {{ checkup.hospital }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { getDiseaseHistory, getCheckupHistory } from '@/services/diseaseHistoryService';

const selectedYear = ref('2024');
const diseases = ref([]);
const checkups = ref([]);
const loading = ref(false);
const error = ref({
  diseases: null,
  checkups: null
});

const loadData = async () => {
  loading.value = true;
  error.value = { diseases: null, checkups: null };

  try {
    const diseaseResponse = await getDiseaseHistory(selectedYear.value);
    diseases.value = diseaseResponse.data.data || [];
  } catch (err) {
    error.value.diseases = err.response?.data?.message || 'Failed to load disease history';
  }

  try {
    const checkupResponse = await getCheckupHistory(selectedYear.value);
    checkups.value = checkupResponse.data.data || [];
  } catch (err) {
    error.value.checkups = err.response?.data?.message || 'Failed to load checkup history';
  }

  loading.value = false;
};

onMounted(() => {
  loadData();
});
</script>