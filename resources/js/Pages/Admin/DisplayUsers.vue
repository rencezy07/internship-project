<script setup>
import { defineProps } from "vue";

const props = defineProps({
  users: {
    type: Array,
    default: () => [], // Default to an empty array if no user data
  },
});
</script>

<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <!-- Page Title -->
    <h1 class="text-4xl font-extrabold text-[#00FFAB] mb-8 text-center">
      Student List
    </h1>

    <!-- Table Wrapper for Large Screens -->
    <div class="hidden lg:block">
      <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <!-- Table Header -->
          <thead class="bg-[#00FFAB] text-slate-900">
            <tr>
              <th class="px-6 py-4 text-left text-sm font-semibold uppercase">
                Profile Picture
              </th>
              <th class="px-6 py-4 text-left text-sm font-semibold uppercase">
                First Name
              </th>
              <th class="px-6 py-4 text-left text-sm font-semibold uppercase">
                Last Name
              </th>
              <th class="px-6 py-4 text-left text-sm font-semibold uppercase">
                Email
              </th>
              <th class="px-6 py-4 text-left text-sm font-semibold uppercase">
                Total Applications
              </th>
            </tr>
          </thead>

          <!-- Table Body -->
          <tbody class="divide-y divide-gray-300">
            <tr
              v-for="user in users"
              :key="user.id"
              class="hover:bg-[#00FFAB]/10 transition-all"
            >
              <!-- Profile Picture -->
              <td class="px-6 py-4">
                <img
                  :src="user.profile_picture || 'https://via.placeholder.com/50'"
                  alt="Profile Picture"
                  class="w-14 h-14 rounded-full object-cover border-2 border-gray-200 shadow-sm"
                />
              </td>

              <!-- First Name -->
              <td class="px-6 py-4 text-gray-800 font-semibold">
                {{ user.first_name }}
              </td>

              <!-- Last Name -->
              <td class="px-6 py-4 text-gray-800 font-semibold">
                {{ user.last_name }}
              </td>

              <!-- Email -->
              <td class="px-6 py-4 text-gray-600">{{ user.email }}</td>

              <!-- Total Applications -->
              <td class="px-6 py-4">
                <span
                  class="inline-block px-3 py-1 bg-[#00FFAB] text-white text-xs font-semibold rounded-full shadow"
                >
                  {{ user.total_applications }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Card-based Layout for Small Screens -->
    <div class="lg:hidden grid grid-cols-1 gap-6">
      <div
        v-for="user in users"
        :key="user.id"
        class="flex flex-col bg-white p-4 rounded-lg shadow-lg"
      >
        <!-- Profile & Basic Info -->
        <div class="flex items-center space-x-4 mb-4">
          <img
            :src="user.profile_picture || 'https://via.placeholder.com/50'"
            alt="Profile Picture"
            class="w-16 h-16 rounded-full object-cover border-2 border-gray-200 shadow-sm"
          />
          <div>
            <p class="text-lg font-bold text-gray-800">
              {{ user.first_name }} {{ user.last_name }}
            </p>
            <p class="text-gray-500 text-sm">{{ user.email }}</p>
          </div>
        </div>

        <!-- Total Applications -->
        <div class="flex items-center justify-between">
          <span class="text-gray-600 font-medium">Total Applications:</span>
          <span
            class="px-3 py-1 bg-[#00FFAB] text-white text-xs font-semibold rounded-full shadow"
          >
            {{ user.total_applications }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
