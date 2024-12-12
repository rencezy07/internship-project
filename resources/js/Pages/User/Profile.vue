<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  user: Object,
});

// Form for profile updates
const form = useForm({
  first_name: props.user?.first_name || '',
  last_name: props.user?.last_name || '',
  email: props.user?.email || '',
  current_password: '', // To validate the current password
  new_password: '', // New password field
  new_password_confirmation: '', // Confirm the new password
  dob: props.user?.dob || '',
  phone_number: props.user?.phone_number || '',
  gender: props.user?.gender || 'male',
  university: props.user?.university || '',
  college_level: props.user?.college_level || 'freshman',
  profile_picture: null,
});

const handleFileChange = (event) => {
  form.profile_picture = event.target.files[0];
};

const submit = () => {
  form.post(route('user.profile.update'), {
    onSuccess: () => {
      alert('Profile updated successfully!');
      // Clear password fields
      form.current_password = '';
      form.new_password = '';
      form.new_password_confirmation = '';
    },
    onError: (errors) => {
      console.error(errors); // Log the errors for debugging
    },
  });
};
</script>

<template>
  <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Edit Profile</h2>
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <!-- Error Messages -->
      <div v-if="form.errors.email" class="text-red-500 text-sm mb-1">
        {{ form.errors.email }}
      </div>
      <div v-if="form.errors.current_password" class="text-red-500 text-sm mb-1">
        {{ form.errors.current_password }}
      </div>
      <div v-if="form.errors.new_password" class="text-red-500 text-sm mb-1">
        {{ form.errors.new_password }}
      </div>

      <!-- First Name -->
      <div class="mb-4">
        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
        <input
          v-model="form.first_name"
          type="text"
          id="first_name"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          required
        />
      </div>

      <!-- Last Name -->
      <div class="mb-4">
        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
        <input
          v-model="form.last_name"
          type="text"
          id="last_name"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          required
        />
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input
          v-model="form.email"
          type="email"
          id="email"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          required
        />
      </div>

      <!-- Current Password -->
      <div class="mb-4">
        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
        <input
          v-model="form.current_password"
          type="password"
          id="current_password"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Enter your current password"
          required
        />
      </div>

      <!-- New Password -->
      <div class="mb-4">
        <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
        <input
          v-model="form.new_password"
          type="password"
          id="new_password"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Enter your new password"
        />
      </div>

      <!-- Confirm New Password -->
      <div class="mb-4">
        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
        <input
          v-model="form.new_password_confirmation"
          type="password"
          id="new_password_confirmation"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Confirm your new password"
        />
      </div>

      <!-- Profile Picture -->
      <div class="mb-4">
        <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
        <input
          type="file"
          id="profile_picture"
          @change="handleFileChange"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        />
      </div>

      <!-- Submit Button -->
      <div class="text-right">
        <button
          type="submit"
          class="bg-indigo-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-indigo-700 focus:outline-none"
        >
          Save Changes
        </button>
      </div>
    </form>
  </div>
</template>
