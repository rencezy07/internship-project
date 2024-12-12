<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

const page = usePage();
const company = page.props.company;

const form = useForm({
  company_name: company.company_name || "",
  email: company.email || "",
  location: company.location || "",
  company_logo: null, // New logo upload
  business_permit: null, // New business permit upload
  password: "", // Current password
  new_password: "", // New password
  confirm_password: "", // Confirm new password
});

const submit = () => {
  form.post(route("company.profile.update"), {
    onFinish: () => {
      form.reset("password", "new_password", "confirm_password"); // Clear password fields
      form.clearErrors("password", "new_password", "confirm_password"); // Clear password-related errors
    },
  });
}; 
</script>

<template>
  <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-4">Company Profile</h1>

    <!-- Display Errors -->
    <div v-if="form.errors" class="text-red-500 mb-4">
      <p v-for="(error, field) in form.errors" :key="field">{{ error }}</p>
    </div>

    <form @submit.prevent="submit">
      <!-- Company Name -->
      <div class="mb-4">
        <label for="company_name" class="block font-medium">Company Name</label>
        <input
          v-model="form.company_name"
          id="company_name"
          type="text"
          class="w-full border-gray-300 rounded-lg shadow-sm"
          required
        />
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block font-medium">Email</label>
        <input
          v-model="form.email"
          id="email"
          type="email"
          class="w-full border-gray-300 rounded-lg shadow-sm"
          required
        />
      </div>

      <!-- Location -->
      <div class="mb-4">
        <label for="location" class="block font-medium">Location</label>
        <input
          v-model="form.location"
          id="location"
          type="text"
          class="w-full border-gray-300 rounded-lg shadow-sm"
          required
        />
      </div>

      <!-- Company Logo -->
      <div class="mb-4">
        <label for="company_logo" class="block font-medium">Company Logo</label>
        <input
          @change="form.company_logo = $event.target.files[0]"
          id="company_logo"
          type="file"
          accept="image/*"
          class="w-full"
        />
      </div>

      <!-- Business Permit -->
      <div class="mb-4">
        <label for="business_permit" class="block font-medium">Business Permit</label>
        <input
          @change="form.business_permit = $event.target.files[0]"
          id="business_permit"
          type="file"
          accept=".pdf"
          class="w-full"
        />
      </div>

      <!-- Current Password -->
      <div class="mb-4">
        <label for="password" class="block font-medium">Current Password</label>
        <input
          v-model="form.password"
          id="password"
          type="password"
          class="w-full border-gray-300 rounded-lg shadow-sm"
          required
        />
      </div>

      <!-- New Password -->
      <div class="mb-4">
        <label for="new_password" class="block font-medium">New Password (Optional)</label>
        <input
          v-model="form.new_password"
          id="new_password"
          type="password"
          class="w-full border-gray-300 rounded-lg shadow-sm"
        />
      </div>

      <!-- Confirm New Password -->
      <div class="mb-4">
        <label for="confirm_password" class="block font-medium">Confirm New Password</label>
        <input
          v-model="form.confirm_password"
          id="confirm_password"
          type="password"
          class="w-full border-gray-300 rounded-lg shadow-sm"
        />
      </div>

      <!-- Submit Button -->
      <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
      >
        Update Profile
      </button>
    </form>
  </div>
</template>
