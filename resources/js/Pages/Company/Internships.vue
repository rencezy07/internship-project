<script setup>
import { useForm } from '@inertiajs/vue3';

// Form for adding a new internship
const internshipForm = useForm({
  internship_name: '',
  city: '',
  status: 'full-time',  // Default to 'full-time'
  salary: '',
  about: '',
  requirements: '',
  image: 'null',
  duration: '',          // New field for internship duration
  start_date: '',        // New field for start date
  end_date: '',          // New field for end date
  benefits: '',          // New field for benefits
  application_deadline: '', // New field for application deadline
  tags: '',              // New field for tags
});

// Fetch internships data passed from the controller
const props = defineProps({
  internships: Array,  // Internships passed from the controller
});

// Form submission
const submitForm = () => {
  internshipForm.post(route('company.internship.store'), {
    onSuccess: () => {
      internshipForm.reset();
    },
  });
};
</script>

<template>
  <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Add Internship</h2>
    
    <!-- Internship Form -->
    <form @submit.prevent="submitForm">

      <!-- Upload Image -->
      <div class="mb-4">
        <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
        <input
          @change="event => (internshipForm.image = event.target.files[0])"
          type="file"
          id="image"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          accept="image/*"
          required
        />
      </div>

      <!-- Internship Name -->
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

      <!-- City -->
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

      <!-- Internship Status -->
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

      <!-- Salary -->
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

      <!-- About -->
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

      <!-- Requirements -->
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

    
      <!-- Duration -->
      <div class="mb-4">
        <label for="duration" class="block text-sm font-medium text-gray-700">Internship Duration</label>
        <input
          v-model="internshipForm.duration"
          type="text"
          id="duration"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="e.g., 3 months"
          required
        />
      </div>

      <!-- Start Date -->
      <div class="mb-4">
        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
        <input
          v-model="internshipForm.start_date"
          type="date"
          id="start_date"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          required
        />
      </div>

      <!-- End Date -->
      <div class="mb-4">
        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
        <input
          v-model="internshipForm.end_date"
          type="date"
          id="end_date"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          required
        />
      </div>

      <!-- Benefits -->
      <div class="mb-4">
        <label for="benefits" class="block text-sm font-medium text-gray-700">Benefits (optional)</label>
        <textarea
          v-model="internshipForm.benefits"
          id="benefits"
          rows="3"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Describe the benefits or perks"
        ></textarea>
      </div>

      <!-- Application Deadline -->
      <div class="mb-4">
        <label for="application_deadline" class="block text-sm font-medium text-gray-700">Application Deadline</label>
        <input
          v-model="internshipForm.application_deadline"
          type="date"
          id="application_deadline"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          required
        />
      </div>

      <!-- Tags -->
      <div class="mb-4">
        <label for="tags" class="block text-sm font-medium text-gray-700">Tags (optional)</label>
        <input
          v-model="internshipForm.tags"
          type="text"
          id="tags"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="e.g., marketing, remote, tech"
        />
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

    <!-- Display Internships -->
    <h2 class="text-2xl font-semibold text-gray-700 mt-10 mb-6">Existing Internships</h2>
    <div v-if="props.internships.length > 0">
      <ul>
        <li v-for="internship in props.internships" :key="internship.id" class="mb-4 p-4 border border-gray-300 rounded-md shadow-sm">
          <img v-if="internship.image" :src="`/storage/${internship.image}`" alt="Internship Image">
          <h3 class="font-semibold text-xl">{{ internship.internship_name }}</h3>
          <p class="text-gray-600">{{ internship.city }}</p>
          <p class="text-sm text-gray-500">{{ internship.status }} | Salary: {{ internship.salary }}</p>
          <p class="mt-2">{{ internship.about }}</p>
          <p class="mt-2 font-semibold">Requirements:</p>
          <p>{{ internship.requirements }}</p>
        </li>
      </ul>
    </div>

    <!-- Message if no internships found -->
    <div v-else>
      <p>No internships found.</p>
    </div>
  </div>
</template>

<style scoped>
/* Optional custom styles for the form */
</style>
