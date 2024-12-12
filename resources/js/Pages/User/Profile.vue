<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  user: Object,
});

// Form for profile updates
const form = useForm({
  first_name: props.user?.first_name || '',
  last_name: props.user?.last_name || '',
  email: props.user?.email || '',
  current_password: '', // Current password for validation
  new_password: '', // New password field (optional)
  new_password_confirmation: '', // New password confirmation field
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



const deleteAccount = () => {
  // Check if the current password is provided
  if (!form.current_password) {
    alert('Please enter your current password to confirm account deletion.');
    return;
  }

  // Confirm the action with the user
  if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
    form.delete(route('user.delete'), {
      data: { current_password: form.current_password },
      onSuccess: () => {
        alert('Your account has been deleted successfully.');
        // Optionally redirect to login or home page after deletion
        window.location.href = '/login';  // Or any route you'd like to redirect to
      },
      onError: (errors) => {
        // Handle errors, such as password mismatch or any other issue
        if (errors.current_password) {
          alert(errors.current_password[0]); // Show the error message for the password field
        } else {
          alert('There was an issue deleting your account. Please try again.');
        }
      },
    });
  }
};


const submit = () => {
  if (!form.current_password) {
    alert('Please enter your current password to update your profile.');
    return;
  }

  form.post(route('user.profile.update'), {
    onSuccess: () => {
      alert('Profile updated successfully!');
      // Clear password fields after success
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

    <!-- Delete Account Section -->
    <div class="mt-6 bg-red-100 p-4 rounded-md">
      <h3 class="text-lg font-semibold text-red-700">Delete Account</h3>
      <p class="text-sm text-red-600">This action cannot be undone. Please confirm your password to delete your account.</p>
      <div class="text-right mt-4">
        <button
          @click="deleteAccount"
          class="bg-red-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-red-700 focus:outline-none"
        >
          Delete Account
        </button>
      </div>
    </div>
  </div>
</template>
