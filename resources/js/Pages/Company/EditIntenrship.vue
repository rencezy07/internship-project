<script setup>
import { useForm } from '@inertiajs/vue3';

// Props passed from the backend
const props = defineProps({
  internship: Object,
});

// Form for editing the internship
const form = useForm({
  title: props.internship.title,
  description: props.internship.description,
  location: props.internship.location,
  salary: props.internship.salary,
});

// Submit handler
const submit = () => {
  form.put(route('internship.update', { internshipId: props.internship.id }), {
    onSuccess: () => {
      alert('Internship updated successfully!');
    },
    onError: (errors) => {
      console.error(errors);
    },
  });
};
</script>

<template>
  <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Edit Internship</h1>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input
          id="title"
          v-model="form.title"
          type="text"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
        />
      </div>
      <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea
          id="description"
          v-model="form.description"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
        ></textarea>
      </div>
      <div class="mb-4">
        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
        <input
          id="location"
          v-model="form.location"
          type="text"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
        />
      </div>
      <div class="mb-4">
        <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
        <input
          id="salary"
          v-model="form.salary"
          type="number"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
        />
      </div>
      <div class="flex justify-end">
        <button
          type="submit"
          class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
        >
          Save Changes
        </button>
      </div>
    </form>
  </div>
</template>
