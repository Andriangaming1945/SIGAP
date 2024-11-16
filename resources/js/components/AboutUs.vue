<template>
    <section class="about-us py-20 text-white">
      <div class="max-w-5xl mx-auto text-left"> <!-- Left align text -->
        <h2 class="text-4xl font-bold mb-8">Tentang Kami</h2>
        <p class="mb-6 text-lg leading-relaxed">
          SIGAP adalah organisasi yang berdedikasi untuk membantu meningkatkan kesehatan masyarakat. Kami berkomitmen untuk menyediakan sistem pemantauan kesehatan yang terpadu, membantu Anda menjalani hidup yang lebih sehat.
        </p>
        <p class="mb-6 text-lg leading-relaxed">
          Konsultasikan kesehatan Anda dengan para ahli kami. Kami siap membantu Anda mencapai tujuan kesehatan Anda.
        </p>
      </div>
    </section>
  </template>
  
  <script>
  export default {
    name: 'AboutUs',
  }
  </script>
  
  <style scoped>
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
  
  .about-us {
    /* Animated background */
    background-size: 400% 400%; /* Increase size for animation effect */
    animation: gradientAnimation 15s ease infinite; /* Control speed of animation */
    position: relative;
    z-index: 1; /* Ensure content appears above background */
    font-family: 'Roboto', sans-serif; /* Apply the chosen font */
    overflow: hidden; /* Hide any overflow */
  }
  
  h2 {
    color: black; /* Set heading color to white */
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Optional text shadow for better contrast */
  }
  
  p {
    color: black /* Set paragraph text color to white */
  }
  
  .text-left {
    text-align: left; /* Left align text */
  }
  
  /* Keyframes for background animation */
  @keyframes gradientAnimation {
    0% {
      background-position: 0% 50%; /* Start position */
    }
    50% {
      background-position: 100% 50%; /* Middle position */
    }
    100% {
      background-position: 0% 50%; /* End position */
    }
  }
  </style>
  