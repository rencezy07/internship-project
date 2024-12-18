<template>
    <div
      class="bg-[#F4F4F4] p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:scale-105"
    >
      <i class="fas fa-quote-left text-[#00FFAB] text-3xl"></i>
      <p class="italic text-gray-700 mt-4">{{ text }}</p>
      <p class="mt-4 font-bold text-[#00FFAB]">{{ name }}</p>
    </div>
  </template>
  
  <script setup>
  defineProps({
    text: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
  });
  </script>
  