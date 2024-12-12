<script setup>
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';

// // Receive internships as props
// const props = defineProps({
//   internships: Array, // The internships passed from the backend
// });

// Handle form submission
const form = useForm({
  email: '',
  password: '',
});

const submit = () => {
  form.post(route('user.login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <div class="flex h-screen">

    <!-- Left Column: Available Internships -->
    <!-- <div class="w-full sm:w-1/2 bg-gray-50 p-8 flex flex-col justify-center">
      <h3 class="text-2xl font-semibold text-center text-gray-800 mb-4">Available Internships</h3>

      <ul class="space-y-4">
        <li v-for="internship in props.internships" :key="internship.id" class="p-4 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100">
          <h4 class="font-semibold text-lg text-gray-800">{{ internship.internship_name }}</h4>
          <p class="text-sm text-gray-600">Company: {{ internship.company_name }}</p>
          <p class="text-sm text-gray-600">Location: {{ internship.city }}</p>
          <p class="text-sm text-gray-600">Status: {{ internship.is_open ? 'Active' : 'Inactive' }}</p>
        </li>
      </ul>
    </div> -->

    <!-- Right Column: Login Form -->
    <div class="w-full sm:w-1/2 bg-blue-50 p-8 flex flex-col justify-center">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Login</h1>
      <form @submit.prevent="submit" class="space-y-4">
        <div v-if="form.errors.email" class="text-red-500 text-sm">
        {{ form.errors.email }}
      </div>
        <div>

        <input
          v-model="form.email"
          type="email"
          name="email"
          placeholder="Email"
          required
          class="w-full p-3 border border-gray-300 rounded-md"
          :class="{ 'border-red-500': form.errors.email }"

        />

  
      </div>

      <div>

        <input
          v-model="form.password"
          type="password"
          name="password"
          placeholder="Password"
          required
          class="w-full p-3 border border-gray-300 rounded-md"
          :class="{ 'border-red-500': form.errors.email }"

        />
     
      </div>

        <label class="flex items-center space-x-2">
          <input type="checkbox" v-model="form.remember" />
          <span class="text-sm text-gray-600">Remember Me</span>
        </label>
        <button
          type="submit"
          class="w-full p-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
        >
          Login
        </button>
      </form>
    </div>

  </div>
</template>

<style scoped>
/* Optional styles for custom scrollbars */
</style>
