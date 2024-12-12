<script setup>
const props = defineProps({
  companies: Array, // Expect the companies array as a prop from the server
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
        </tr>
      </tbody>
    </table>
  </div>
</template>
