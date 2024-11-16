<template>
    <div class="container py-5">
      <h2 class="centered-text">Statistik Penyakit</h2>
      <div class="row justify-content-center">
        <div class="col-12 col-md-8">
          <canvas id="myBarChart"></canvas>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { Chart } from "chart.js/auto";
  
  export default {
    data() {
      return {
        chart: null
      };
    },
    mounted() {
      this.renderChart();
    },
    methods: {
      renderChart() {
        const ctx = document.getElementById("myBarChart").getContext("2d");
        this.chart = new Chart(ctx, {
          type: "bar",
          data: {
            labels: ["Influenza", "Demam Berdarah", "Covid-19", "Malaria", "HIV", "TBC"],
            datasets: [
              {
                label: "Kasus Penyakit (Ribu Kasus)",
                data: [120, 150, 80, 60, 40, 100],
                backgroundColor: [
                  "rgba(255, 99, 132, 0.2)",
                  "rgba(54, 162, 235, 0.2)",
                  "rgba(255, 206, 86, 0.2)",
                  "rgba(75, 192, 192, 0.2)",
                  "rgba(153, 102, 255, 0.2)",
                  "rgba(255, 159, 64, 0.2)"
                ],
                borderColor: [
                  "rgba(255, 99, 132, 1)",
                  "rgba(54, 162, 235, 1)",
                  "rgba(255, 206, 86, 1)",
                  "rgba(75, 192, 192, 1)",
                  "rgba(153, 102, 255, 1)",
                  "rgba(255, 159, 64, 1)"
                ],
                borderWidth: 1
              }
            ]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
    }
  };
  </script>
  
  <style scoped>
  canvas {
    width: 100% !important; /* Ensure the canvas is responsive */
    height: auto;
    margin: 20px auto;
  }
  
  .centered-text {
    text-align: center;
    margin-bottom: 20px;
  }
  </style>
  