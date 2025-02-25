<template>
    <div class="flex items-center justify-center">
      <h1 class="text-4xl font-bold relative overflow-hidden">
        <span class="gradient-text">MoexLab</span>
      </h1>
    </div>
  </template>

  <script>
  export default {
    name: 'Logo',
  }
  </script>

  <style scoped>
  .gradient-text {
    background: linear-gradient(270deg, #ffdd00, #ff6f00, #ff2e00, #ff00c8, #8a00ff, #00c8ff, #00ff6f, #00ff00);
    background-size: 400% 400%;
    background-clip: text;
    -webkit-background-clip: text; /* Для поддержки в WebKit браузерах */
    color: transparent; /* Делаем текст прозрачным */
    animation: gradient 7s ease infinite;
  }

  @keyframes gradient {
    0% {
      background-position: 0% 50%;
    }
    50% {
      background-position: 100% 50%;
    }
    100% {
      background-position: 0% 50%;
    }
  }
  </style>

