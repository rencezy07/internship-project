<script setup>
const props = defineProps({
  companies: Array, // Expect the companies array as a prop from the server
  summaries: Array,

});
</script>

<template>
  <div class="p-6 bg-gray-100">
    <h1 class="text-2xl font-bold mb-4">View Companies</h1>
    <table class="w-full bg-white shadow rounded">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="p-3">Company Logo</th>
          <th class="p-3">Company Name</th>
          <th class="p-3">Email</th>
          <th class="p-3">Total Internships</th>

        </tr>
      </thead>
      <tbody>
        <tr v-for="company in companies" :key="company.id" class="border-t">
          <td class="p-3">
            <img
              :src="company.company_logo || 'https://via.placeholder.com/50'"
              alt="Company Logo"
              class="w-12 h-12 rounded-full"
            />
          </td>
          <td class="p-3">{{ company.company_name }}</td>
          <td class="p-3">{{ company.email }}</td>
          <td class="p-3">
            {{ company.total_internships > 0 ? company.total_internships : 0 }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="p-6 bg-gray-100">
    <h1 class="text-3xl font-bold text-[#00FFAB] mb-6">Company Applications Summary</h1>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
      <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-800 text-white">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold">Company ID</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Company Name</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Total Applications</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Under Review</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Accepted</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Rejected</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="summary in summaries" :key="summary.company_id">
            <td class="px-6 py-4">{{ summary.company_id }}</td>
            <td class="px-6 py-4">{{ summary.company_name }}</td>
            <td class="px-6 py-4">{{ summary.total_applications }}</td>
            <td class="px-6 py-4">{{ summary.under_review_count }}</td>
            <td class="px-6 py-4">{{ summary.accepted_count }}</td>
            <td class="px-6 py-4">{{ summary.rejected_count }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
