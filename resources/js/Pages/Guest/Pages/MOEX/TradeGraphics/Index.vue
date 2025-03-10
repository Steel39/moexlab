<template>
    <div class="min-h-screen bg-gray-900 dark">
      <div class="max-w-7xl mx-auto p-4">
        <h2 class="text-3xl font-extrabold mb-8 text-center text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-orange-500">
          24-часовой объем торгов
        </h2>
        <div class="bg-gray-800 rounded-3xl shadow-2xl p-6 h-[50vh]">
          <Line
            :data="chartData"
            :options="chartOptions"
            class="h-full"
          />
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'
  import { Line } from 'vue-chartjs'
  import { Chart, registerables } from 'chart.js'

  Chart.register(...registerables)

  // Генерация временных меток с 30-минутным интервалом
  const timeLabels = Array.from({ length: 48 }, (_, i) => {
    const hour = String(Math.floor(i / 2)).padStart(2, '0')
    const minute = i % 2 === 0 ? '00' : '30'
    return `${hour}:${minute}`
  })

  // Генерация демонстрационных данных
  const generateData = (base, variance) => {
    return Array.from({ length: 48 }, () =>
      Math.max(0, Math.round(base + (Math.random() - 0.5) * variance))
    )
  }

  const chartData = ref({
    labels: timeLabels,
    datasets: [
      {
        label: 'Покупки',
        data: generateData(150, 80),
        borderColor: '#00FF00',
        backgroundColor: 'rgba(0, 255, 0, 0.2)',
        tension: 0.3,
        pointRadius: 0,
        borderWidth: 2,
        fill: true,
        pointHoverRadius: 6,
        pointHoverBackgroundColor: '#00FF00'
      },
      {
        label: 'Продажи',
        data: generateData(120, 100),
        borderColor: '#FF4500',
        backgroundColor: 'rgba(255, 69, 0, 0.2)',
        tension: 0.3,
        pointRadius: 0,
        borderWidth: 2,
        fill: true,
        pointHoverRadius: 6,
        pointHoverBackgroundColor: '#FF4500'
      }
    ]
  })

  const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    animation: {
      duration: 2000,
      easing: 'easeInOutQuad'
    },
    plugins: {
      legend: {
        position: 'top',
        labels: {
          color: '#E0E7FF',
          font: {
            size: 14
          },
          usePointStyle: true,
          pointStyle: 'circle'
        }
      },
      tooltip: {
        enabled: true,
        mode: 'index',
        intersect: false,
        backgroundColor: '#1E293B',
        titleColor: '#E2E8F0',
        bodyColor: '#E2E8F0',
        borderColor: '#334155',
        borderWidth: 1
      }
    },
    scales: {
      x: {
        title: {
          display: true,
          text: 'Время (30-минутные интервалы)',
          color: '#E0E7FF',
          font: {
            size: 14,
            weight: 'bold'
          }
        },
        grid: {
          color: '#475569',
          lineWidth: 0.5
        },
        ticks: {
          color: '#94A3B8',
          maxTicksLimit: 24
        }
      },
      y: {
        title: {
          display: true,
          text: 'Объем операций',
          color: '#E0E7FF',
          font: {
            size: 14,
            weight: 'bold'
          }
        },
        grid: {
          color: '#475569',
          lineWidth: 0.5
        },
        ticks: {
          color: '#94A3B8',
          callback: (value) => `${value} шт`
        }
      }
    }
  }
  </script>

  <style>
  @import 'tailwindcss/base';
  @import 'tailwindcss/components';
  @import 'tailwindcss/utilities';

  .chart-container {
    position: relative;
    margin: auto;
    height: 600px;
  }
  @layer components {
  .chart-container {
    position: relative;
    height: 100%;
    width: 100%;
  }

  .chartjs-render-monitor {
    height: 100% !important;
  }
}
  @keyframes pulse {
    0% { transform: scale(0.95); opacity: 0.8; }
    50% { transform: scale(1); opacity: 1; }
    100% { transform: scale(0.95); opacity: 0.8; }
  }

  .pulse-enter-active {
    animation: pulse 2s ease-in-out;
  }
  </style>
