<!-- src/components/BarcodeScanner.vue -->
<template>
    <div class="scanner-container">
      <!-- Area Scanner -->
      <div id="reader" class="scanner-area"></div>
  
      <!-- Hasil Scan -->
      <div v-if="scannedResult" class="result-area">
        <h3>Nomor Barcode:</h3>
        <div class="barcode-number">{{ scannedResult }}</div>
      </div>
  
      <!-- Loading & Error States -->
      <div v-if="isLoading" class="loading">Memproses...</div>
      <div v-if="error" class="error-message">{{ error }}</div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, onUnmounted } from 'vue';
  import { Html5Qrcode } from 'html5-qrcode';
  import axios from 'axios';
  
  const scannedResult = ref('');
  const isLoading = ref(false);
  const error = ref('');
  let html5QrCode;
  
  const onScanSuccess = async (decodedText) => {
    try {
      scannedResult.value = decodedText;
      isLoading.value = true;
      
      // Kirim ke API
      const response = await axios.post('/api/entries', {
        national_number: decodedText
      });
      
      // Optional: Play beep sound
      
      
    } catch (err) {
      error.value = `Error: ${err.message}`;
    } finally {
      isLoading.value = false;
    }
  };
  
  const onScanError = (err) => {
    // Hanya tampilkan error yang bukan dari proses scanning normal
    if (!err.includes('QR code parse error')) {
      error.value = `Scan Error: ${err}`;
    }
  };
  
  onMounted(async () => {
    try {
      html5QrCode = new Html5Qrcode("reader");
      
      const config = {
        fps: 10,
        qrbox: { width: 250, height: 150 },
        aspectRatio: 1.0,
        experimentalFeatures: {
          useBarCodeDetectorIfSupported: true
        }
      };
  
      await html5QrCode.start(
        { facingMode: "environment" }, // Gunakan kamera belakang
        config,
        onScanSuccess,
        onScanError
      );
    } catch (err) {
      error.value = `Camera Error: ${err.message}`;
    }
  });
  
  onUnmounted(() => {
    if (html5QrCode && html5QrCode.isScanning) {
      html5QrCode.stop().catch(error => console.error(error));
    }
  });
  </script>
  
  <style scoped>
  .scanner-container {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
  }
  
  .scanner-area {
    width: 100%;
    min-height: 300px;
    background: #f5f5f5;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
  }
  
  .result-area {
    margin-top: 20px;
    padding: 15px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    text-align: center;
  }
  
  .barcode-number {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin: 10px 0;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 4px;
  }
  
  .loading {
    text-align: center;
    padding: 10px;
    color: #666;
  }
  
  .error-message {
    color: #dc3545;
    text-align: center;
    padding: 10px;
    margin-top: 10px;
  }
  
  /* Tambahan style untuk memperbaiki tampilan video */
  #reader video {
    width: 100% !important;
    height: auto !important;
    border-radius: 8px;
  }
  
  #reader {
    width: 100% !important;
    border: none !important;
  }
  </style>
 