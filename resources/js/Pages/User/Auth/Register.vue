<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  first_name: '',
  last_name: '',
  email: '',
  password: '',
  password_confirmation: '',
  dob: '',
  phone_number: '', // Match database field name
  gender: 'male',
  university: '',
  college_level: 'freshman', // New field
  profile_picture: null, // File
});

const submit = () => {
  form.post(route('user.register'), {
    onFinish: () => form.reset('password'),
  });
};

const handleFileChange = (e) => {
  form.profile_picture = e.target.files[0];
};
</script>

<template>
  <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Register</h2>
    <form @submit.prevent="submit">
      <!-- First Name -->
      <div class="mb-4">
        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
        <input
          v-model="form.first_name"
          type="text"
          id="first_name"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Enter your first name"
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
          placeholder="Enter your last name"
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
          placeholder="Enter your email"
          required
          autocomplete="email"

        />
      </div>

      <!-- Password -->
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input
          v-model="form.password"
          type="password"
          id="password"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Enter your password"
          required
          autocomplete="new-password"

        />
      </div>

      <!-- Confirm Password -->
      <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input
          v-model="form.password_confirmation"
          type="password"
          id="password_confirmation"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Confirm your password"
          required
          autocomplete="new-password"

        />
      </div>

      <!-- Date of Birth -->
      <div class="mb-4">
        <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
        <input
          v-model="form.dob"
          type="date"
          id="dob"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          required
        />
      </div>

      <!-- Phone -->
      <div class="mb-4">
        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
        <input
          v-model="form.phone_number"
          type="tel"
          id="phone_number"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Enter your phone number"
          required
        />
      </div>

      <!-- Gender -->
      <div class="mb-4">
        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
        <select
          v-model="form.gender"
          id="gender"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          required
        >
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>

      <!-- University -->
      <div class="mb-4">
        <label for="university" class="block text-sm font-medium text-gray-700">University</label>
        <input
          v-model="form.university"
          type="text"
          id="university"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          placeholder="Enter your university"
          required
        />
      </div>

      <!-- College Level -->
      <div class="mb-4">
        <label for="college_level" class="block text-sm font-medium text-gray-700">College Level</label>
        <select
          v-model="form.college_level"
          id="college_level"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          required
        >
          <option value="freshman">Freshman</option>
          <option value="sophomore">Sophomore</option>
          <option value="junior">Junior</option>
          <option value="senior">Senior</option>
        </select>
      </div>

      <!-- Profile Picture -->
      <div class="mb-4">
        <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
        <input
          type="file"
          id="profile_picture"
          @change="handleFileChange"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          required
        />
      </div>

      <!-- Submit Button -->
      <div class="mb-4 text-right">
        <button
          type="submit"
          class="bg-indigo-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-indigo-700 focus:outline-none"
        >
          Register
        </button>
      </div>
    </form>
  </div>
</template>
