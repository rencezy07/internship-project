<script setup>
const props = defineProps({
  applications: Array, // Array of internship applications
});
</script>

<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-[#00FFAB] mb-6">Student Internship Applications</h1>

    <!-- Table Wrapper -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
      <table class="min-w-full divide-y divide-gray-200">
        <!-- Table Header -->
        <thead class="bg-[#00FFAB] text-white">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Applicant Name</th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Internship Name</th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Company Name</th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Status</th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Salary</th>
          </tr>
        </thead>

        <!-- Table Body -->
        <tbody class="divide-y divide-gray-300">
          <tr
            v-for="application in applications"
            :key="application.internship_name"
            class="hover:bg-gray-100 transition"
          >
            <!-- Applicant Name -->
            <td class="px-6 py-4 text-gray-700 whitespace-nowrap font-medium">
              {{ application.first_name }} {{ application.last_name }}
            </td>

            <!-- Internship Name -->
            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
              {{ application.internship_name }}
            </td>

            <!-- Company Name -->
            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
              {{ application.company_name }}
            </td>

            <!-- Status with Color-Coded Tags -->
            <td class="px-6 py-4 whitespace-nowrap">
              <span
                class="inline-block px-3 py-1 rounded-full text-xs font-semibold"
                :class="{
                  'bg-green-100 text-green-600': application.application_status === 'accepted',
                  'bg-red-100 text-red-600': application.application_status === 'rejected',
                  'bg-yellow-100 text-yellow-600': application.application_status === 'under review',
                }"
              >
                {{ application.application_status }}
              </span>
            </td>

            <!-- Salary -->
            <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
              {{ application.salary }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style>
/* Custom scrollbar for table scrolling on smaller screens */
::-webkit-scrollbar {
  height: 8px;
}

::-webkit-scrollbar-thumb {
  background-color: #00ffab;
  border-radius: 4px;
}

::-webkit-scrollbar-track {
  background-color: #f1f1f1;
}
</style>
