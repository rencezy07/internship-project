<script setup>
import { usePage } from '@inertiajs/vue3';

// Access props passed from the backend
const {
  totalUsers = 0,
  totalCompanies = 0,
  totalApplications = 0,
  verifiedCompanies = 0,
  underReviewApplications = 0,
  recentUsers = [],
  recentCompanies = []
} = usePage().props;
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
      <div class="p-4 bg-white shadow rounded">
        <h2 class="text-lg font-semibold">Total Users</h2>
        <p class="text-2xl font-bold text-indigo-600">{{ totalUsers }}</p>
      </div>
      <div class="p-4 bg-white shadow rounded">
        <h2 class="text-lg font-semibold">Total Companies</h2>
        <p class="text-2xl font-bold text-indigo-600">{{ totalCompanies }}</p>
      </div>
      <div class="p-4 bg-white shadow rounded">
        <h2 class="text-lg font-semibold">Total Applications</h2>
        <p class="text-2xl font-bold text-indigo-600">{{ totalApplications }}</p>
      </div>
      <div class="p-4 bg-white shadow rounded">
        <h2 class="text-lg font-semibold">Verified Companies</h2>
        <p class="text-2xl font-bold text-indigo-600">{{ verifiedCompanies }}</p>
      </div>
      <div class="p-4 bg-white shadow rounded">
        <h2 class="text-lg font-semibold">Pending Applications</h2>
        <p class="text-2xl font-bold text-indigo-600">{{ underReviewApplications }}</p>
      </div>
    </div>

    <!-- Recent Registrations -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Recent Users -->
      <div class="p-4 bg-white shadow rounded">
        <h2 class="text-lg font-semibold mb-4">Recent Users</h2>
        <ul>
          <li v-for="user in recentUsers" :key="user.id" class="mb-2">
            <p class="text-sm font-medium">{{ user.first_name }} {{ user.last_name }}</p>
            <p class="text-sm text-gray-500">Email: {{ user.email }}</p>
          </li>
        </ul>
      </div>

      <!-- Recent Companies -->
      <div class="p-4 bg-white shadow rounded">
        <h2 class="text-lg font-semibold mb-4">Recent Companies</h2>
        <ul>
          <li v-for="company in recentCompanies" :key="company.id" class="mb-2">
            <p class="text-sm font-medium">{{ company.company_name }}</p>
            <p class="text-sm text-gray-500">Email: {{ company.email }}</p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
