<template>
    <a :href="link" class="block bg-gray-800 p-6 rounded-lg shadow transition-transform
     transform hover:scale-105 hover:shadow-lg hover:shadow-lime-400">
      <h3 class="text-2xl font-semibold text-white">{{ title }}</h3>
      <p class="text-gray-300">{{ description }}</p>
    </a>
  </template>

  <script>
  export default {
    name: 'ServiceCard',
    props: {
      title: {
        type: String,
        required: true,
      },
      description: {
        type: String,
        required: true,
      },
      link: {
        type: String,
        required: true,
      },
    },
  }
  </script>

  <style scoped>
  /* Добавьте дополнительные стили, если необходимо */
  </style>

