<template>
    <div
      class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-300 group"
    >
      <i :class="`${icon} text-4xl mb-4`" :style="{ color: primaryColor }"></i>
      <h3
        class="text-2xl font-bold mb-4 transition duration-300 group-hover:text-[#4FB148]"
        :style="{ color: primaryColor }"
      >
        {{ title }}
      </h3>
      <p class="text-gray-700 leading-relaxed">{{ text }}</p>
    </div>
  </template>
  
  <script setup>
  defineProps({
    icon: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
    text: {
      type: String,
      required: true,
    },
    primaryColor: {
      type: String,
      default: "#113F1F",
    },
  });
  </script>
  