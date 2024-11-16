<template>
    <footer class="bg-blue-900 text-white py-12">
      <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 px-6">
        <!-- Info RS -->
        <div class="space-y-4">
          <h3 class="font-bold text-xl mb-6 text-blue-200">
            INFO RSUD DR.ABDOER RAHEM SITUBONDO
          </h3>
          <div class="text-gray-300 leading-relaxed">
            <p>
              Jl. Anggrek Jl. Alas Malang No.96, Patokan Utara, Patokan, Kec. Situbondo, 
              Kabupaten Situbondo, Jawa Timur 68312
            </p>
            <div class="mt-6 space-y-2">
              <p class="flex items-center hover:text-blue-200 transition-colors">
                <span class="font-medium">Telp:</span>
                <span class="ml-2">(0338) 673953</span>
              </p>
              <p class="flex items-center hover:text-blue-200 transition-colors">
                <span class="font-medium">Email:</span>
                <span class="ml-2">rsku@gmail.com</span>
              </p>
            </div>
          </div>
        </div>
  
        <!-- Links -->
        <div>
          <h3 class="font-bold text-xl mb-6 text-blue-200">LINKS</h3>
          <ul class="space-y-3">
            <li v-for="(link, index) in links" :key="index">
              <a 
                href="#" 
                class="text-gray-300 hover:text-blue-200 transition-colors duration-300 block"
              >
                {{ link }}
              </a>
            </li>
          </ul>
        </div>
  
        <!-- Cek Data Antrian -->
        <div>
          <h3 class="font-bold text-xl mb-6 text-blue-200">
            CEK DATA ANTRIAN PENDAFTAR
          </h3>
          <div class="space-y-4">
            <input
              type="text"
              placeholder="Masukkan Kode Antrian"
              class="w-full p-3 rounded-lg bg-white text-gray-800 placeholder-gray-500 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors"
            />
            <button class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors duration-300 w-full md:w-auto">
              Cek Antrian
            </button>
          </div>
        </div>
      </div>
  
      <div class="border-t border-blue-800 mt-10 pt-8 text-center text-gray-400">
        <p>2024 © RSUD DR.ABDOER RAHEM SITUBONDO</p>
      </div>
    </footer>
  </template>
  
  <script>
  export default {
    name: "FooterComponent",
    data() {
      return {
        links: [
          "Pendaftaran Rawat Jalan",
          "Dokter dan Jadwal",
          "Poli",
          "Struktur",
          "Kegiatan",
          "Artikel",
          "Konsultasi"
        ]
      }
    }
  };
  </script>
  
  <style scoped>
  a {
    text-decoration: none;
  }
  
  input::placeholder {
    opacity: 0.7;
  }
  
  input:focus {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
  }
  
  .container {
    max-width: 1200px;
  }
  </style>