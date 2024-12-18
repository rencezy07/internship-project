<script setup>
import { Link } from '@inertiajs/vue3';

import { useForm } from '@inertiajs/vue3';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('company.login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <div class="min-h-screen h-full flex items-center justify-center bg-gradient-to-br from-[#00FFAB] via-gray-200 to-white">
    <!-- Login Card Container -->
    <div
      class="relative flex flex-col md:flex-row items-center w-full shadow-2xl rounded-3xl overflow-hidden bg-white/70 backdrop-blur-lg"
    >
      <!-- Left Image Section -->
      <div class="hidden md:block w-1/2">
        <img
          src="/public/images/company.webp"
          alt="Login Image"
          class="object-cover w-full h-full"
        />
      </div>

      <!-- Login Form Section -->
      <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
        <!-- Logo (Optional) -->
        <div class="flex justify-center mb-6">
          <img src="/public/images/logo.png" alt="Logo" class="h-12" />
        </div>

        <!-- Title -->
        <h1 class="text-4xl font-extrabold text-gray-800 text-center mb-6">Welcome Back!</h1>

        <!-- Error Messages -->
        <div v-if="form.errors.email || form.errors.password" class="text-red-500 text-sm mb-4 text-center">
          <p v-if="form.errors.email">{{ form.errors.email }}</p>
          <p v-if="form.errors.password">{{ form.errors.password }}</p>
        </div>

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-4 ">
          <!-- Email Input -->
          <div>
            <label class="block text-sm font-semibold text-gray-700">Email</label>
            <input
              v-model="form.email"
              type="email"
              placeholder="Enter your email"
              required
              class="w-full px-4 py-3 mt-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00FFAB] focus:outline-none transition-all duration-300"
            />
          </div>

          <!-- Password Input -->
          <div>
            <label class="block text-sm font-semibold text-gray-700">Password</label>
            <input
              v-model="form.password"
              type="password"
              placeholder="Enter your password"
              required
              class="w-full px-4 py-3 mt-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#00FFAB] focus:outline-none transition-all duration-300"
            />
          </div>

          <!-- Remember Me -->
          <div class="flex items-center justify-between text-gray-600">
            <label class="inline-flex items-center">
              <input type="checkbox" v-model="form.remember" class="text-[#00FFAB] focus:ring-[#00FFAB]" />
              <span class="ml-2 text-sm">Remember Me</span>
            </label>
            <a href="#" class="text-sm hover:text-[#00FFAB] transition duration-300">Forgot Password?</a>
          </div>

          <!-- Submit Button -->
           <div class="flex justify-center">
            <button
            type="submit"
            class=" w-1/2 py-3 px-4 text-lg font-semibold text-white bg-[#00FFAB] rounded-lg hover:bg-black hover:text-[#00FFAB] transition duration-300 shadow-lg focus:outline-none focus:ring-2 focus:ring-[#00FFAB]"
          >
            Login
          </button>
           </div>
        </form>

        <!-- Footer -->
        <p class="text-sm text-gray-600 mt-6 text-center">
          Don't have an account?
          <Link
      :href="route('company.register')"
      class="px-1 py-2 text-gray-600 hover:text-[#00FFAB] transition duration-300"
    >
      Signup
    </Link>        </p>
        
      </div>
    </div>
  </div>
</template>


