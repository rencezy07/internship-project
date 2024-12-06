<script setup>
import { useForm } from '@inertiajs/vue3';

const internshipForm = useForm({
  internship_name: '',
  city: '',
  status: 'full-time',  // Default to 'full-time'
  salary: '',
  about: '',
  requirements: '',
});

// Form submission
const submitForm = () => {
  console.log(internshipForm.data());  // Log the form data
  internshipForm.post(route('company.internship.store'));
};

</script>

<template>
  <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Add Internship</h2>
    
    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label for="internship_name" class="block text-sm font-medium text-gray-700">Internship Name</label>
        <input
          v-model="internshipForm.internship_name"
          type="text"
          id="internship_name"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Enter Internship Name"
          required
        />
      </div>

      <div class="mb-4">
        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
        <input
          v-model="internshipForm.city"
          type="text"
          id="city"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Enter City"
          required
        />
      </div>

      <div class="mb-4">
        <label for="status" class="block text-sm font-medium text-gray-700">Internship Status</label>
        <select
          v-model="internshipForm.status"
          id="status"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        >
          <option value="full-time">Full-Time</option>
          <option value="part-time">Part-Time</option>
        </select>
      </div>

      <div class="mb-4">
        <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
        <input
          v-model="internshipForm.salary"
          type="number"
          id="salary"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Enter Salary"
          required
        />
      </div>

      <div class="mb-4">
        <label for="about" class="block text-sm font-medium text-gray-700">About</label>
        <textarea
          v-model="internshipForm.about"
          id="about"
          rows="4"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Describe the internship"
          required
        ></textarea>
      </div>

      <div class="mb-4">
        <label for="requirements" class="block text-sm font-medium text-gray-700">Requirements</label>
        <textarea
          v-model="internshipForm.requirements"
          id="requirements"
          rows="4"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="List the internship requirements"
          required
        ></textarea>
      </div>

      <div class="mb-4 text-right">
        <button
          type="submit"
          class="bg-indigo-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-indigo-700 focus:outline-none"
        >
          Submit
        </button>
      </div>
    </form>
  </div>
</template>

<style scoped>
/* Optional custom styles for the form */
</style>
