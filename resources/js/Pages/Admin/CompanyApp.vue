<script setup>
import { usePage } from '@inertiajs/vue3';
import ApprovalStatusDropdown from '@/Components/ApprovalStatusDropdown.vue';

// Fetch companies from backend props
const { companies } = usePage().props;
</script>

<template>
  <div class="p-6 bg-gray-100 min-h-screen">
    <!-- Page Title -->
    <h1 class="text-3xl font-bold mb-6 text-[#00FFAB]">Company Applications</h1>

    <!-- Responsive Table Wrapper -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
      <table class="min-w-full divide-y divide-gray-200">
        <!-- Table Header -->
        <thead class="bg-[#00FFAB] text-black font-semibold">
          <tr>
            <th
              class="px-6 py-3 text-left text-sm font-semibold uppercase"
            >
              Company Name
            </th>
            <th
              class="px-6 py-3 text-left text-sm font-semibold uppercase"
            >
              Email
            </th>
            <th
              class="px-6 py-3 text-left text-sm font-semibold uppercase"
            >
              Business Permit
            </th>
            <th
              class="px-6 py-3 text-left text-sm font-semibold uppercase"
            >
              Approval Status
            </th>
          </tr>
        </thead>

        <!-- Table Body -->
        <tbody class="divide-y divide-gray-300">
          <tr
            v-for="company in companies"
            :key="company.company_id"
            class="hover:bg-[#00FFAB]/10 transition"
          >
            <!-- Company Name -->
            <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">
              {{ company.company_name }}
            </td>

            <!-- Email -->
            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
              {{ company.email }}
            </td>

            <!-- Business Permit -->
            <td class="px-6 py-4 whitespace-nowrap">
              <a
                v-if="company.business_permit"
                :href="`/storage/${company.business_permit}`"
                target="_blank"
                class="inline-block px-3 py-1 text-sm font-medium text-white bg-[#00FFAB] rounded hover:bg-[#00e6a0] transition"
              >
                View Permit
              </a>
              <span
                v-else
                class="inline-block px-3 py-1 text-sm font-medium text-gray-500"
              >
                No Permit Uploaded
              </span>
            </td>

            <!-- Approval Status -->
            <td class="px-6 py-4 whitespace-nowrap">
              <ApprovalStatusDropdown :company="company" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style>
/* Custom Scrollbar for smaller screens */
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
