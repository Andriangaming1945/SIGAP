<template>
  <div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container">
      <div class="row min-vh-80 align-items-center">
        <div class="col-lg-6 col-12 text-white hero-content">
          <h1 class="display-4 fw-bold mb-4">Kesehatan Anda <br>Prioritas Kami</h1>
          <p class="lead mb-4">Sistem pemantauan kesehatan terpadu untuk membantu Anda menjalani hidup yang lebih sehat. <br>Konsultasikan kesehatan Anda dengan para ahli kami.</p>
          <div class="hero-buttons">
            <button class="btn btn-primary btn-lg me-3">Mulai Konsultasi</button>
            <button class="btn btn-outline-light btn-lg">Pelajari Lebih Lanjut</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { setDevtoolsHook } from 'vue';
</script>

<style>
/* Main Hero Section */
.hero-section {
  position: relative;
  background-image: url('/images/download.jpeg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  height: 80vh;
  margin: 0;
  padding: 0;
  overflow: hidden;
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 79, 179, 0.75);
  z-index: 1;
}

/* Adjust Hero Content Positioning */
.hero-content {
  position: relative;
  z-index: 2;
  padding: 2rem;
  margin-top: 4rem; /* Add more margin to push content down */
  animation: fadeIn 1s ease-in-out;
  margin-left: 60px;
}

/* You can fine-tune the margin-top value as needed */

.hero-content h1 {
  font-size: 3.5rem;
  line-height: 1.2;
  text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.3); /* Deeper shadow for better readability */
}

.hero-content p {
  font-size: 1.25rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
  margin-bottom: 1.5rem;
}

.hero-buttons .btn-primary {
  background-color: #007bff;
  border: none;
  padding: 12px 30px;
  border-radius: 50px; /* Smooth rounded buttons */
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); /* Soft shadow */
  transition: all 0.3s ease-in-out;
}

.hero-buttons .btn-primary:hover {
  background-color: #0056b3;
  transform: translateY(-3px); /* Smooth hover effect */
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
}

.hero-buttons .btn-outline-light {
  border-width: 2px;
  padding: 12px 30px;
  border-radius: 50px;
  transition: all 0.3s ease-in-out;
}

.hero-buttons .btn-outline-light:hover {
  background-color: rgba(255, 255, 255, 0.2);
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
}

/* Animations */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive Design */
@media (max-width: 768px) {
  .hero-content h1 {
    font-size: 2.5rem;
  }

  .hero-content p {
    font-size: 1.1rem;
  }

  .hero-buttons .btn {
    display: block;
    width: 100%;
    margin-bottom: 1rem;
  }

  /* Adjust margin-left for smaller screens */
  .hero-content {
    margin-left: 0;
    margin-top: 2rem; /* Reduce margin-top */
  }
}

@media (max-width: 576px) {
  .hero-content h1 {
    font-size: 2rem;
  }

  .hero-content p {
    font-size: 1rem;
  }
}

.min-vh-80 {
  min-height: 80vh;
}
</style>
