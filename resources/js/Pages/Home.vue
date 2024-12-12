<template>
    <nav class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
      <div>
        <a href="/home" class="text-lg font-semibold hover:text-gray-300">Home</a>
      </div>
      <div class="space-x-4">
        <a href="/user/register" class="hover:text-gray-300">Register</a>
        <a href="/user/login" class="hover:text-gray-300">Login</a>
      </div>
    </nav>

    <Footer />
  </template>
  
  <script setup>
  // No additional logic required for now
import Footer from '@/Components/User/Footer.vue';

  </script>
  