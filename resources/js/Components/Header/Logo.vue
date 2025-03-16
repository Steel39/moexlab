<template>
    <div class="flex items-center justify-center">
      <h1 class="text-4xl font-sans font-bold relative overflow-hidden">
          <button @click="getMainPage" class="p-1  text-shadow">
              <span class="gradient-text">MoexLab</span>
          </button>
      </h1>
    </div>
  </template>

  <script setup>

  import {router} from "@inertiajs/vue3";

  const getMainPage = () => {
      router.get(route('welcome'))
  }
  </script>

  <style scoped>
  .text-shadow {
      text-shadow: 2px 2px 4px rgba(2, 0, 0, 0.5);
  }

  .gradient-text {
      background: linear-gradient(270deg, #ffdd00, #ff6f00, #ff2e00, #ff00c8, #000000, #00ff6f,
      #8a00ff, #00c8ff, #00ff6f, #000000, #ff00c8, #ff2e00, #ff6f00, #ffdd00);
      background-size: 400% 400%; /* Увеличиваем размер фона для плавности */
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent; /* Скрываем исходный цвет текста */
      animation: gradient 20s ease infinite; /* Линейная анимация для бесшовности */
  }

  @keyframes gradient {
      0% {
          background-position: 1% 50%; /* Начало градиента */
      }
      50% {
          background-position: 51% 75%; /* Конец градиента */
      }
      75% {
          background-position: 75% 100%; /* Начало градиента */
      }
      100% {
          background-position: 50% 1%; /* Конец градиента */
      }
  }
  </style>

