<script setup>
import { usePage } from '@inertiajs/vue3';
import ApprovalStatusDropdown from '@/Components/ApprovalStatusDropdown.vue';

const { companies } = usePage().props; // Fetch companies from props
</script>

<template>
  <div>
    <h1 class="text-xl font-bold">Company Applications</h1>

    <table class="min-w-full mt-4 border-collapse border border-gray-300">
      <thead>
        <tr>
          <th class="px-4 py-2 border border-gray-300">Company Name</th>
          <th class="px-4 py-2 border border-gray-300">Email</th>
          <th class="px-4 py-2 border border-gray-300">Business Permit</th>
          <th class="px-4 py-2 border border-gray-300">Approval Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="company in companies" :key="company.company_id">
          <td class="px-4 py-2 border border-gray-300">{{ company.company_name }}</td>
          <td class="px-4 py-2 border border-gray-300">{{ company.email }}</td>
          <td class="px-4 py-2 border border-gray-300">
            <a
              v-if="company.business_permit"
              :href="`/storage/${company.business_permit}`"
              target="_blank"
              class="text-blue-500 underline"
            >
              View Permit
            </a>
            <span v-else>No Permit Uploaded</span>
          </td>
          <td class="px-4 py-2 border border-gray-300">
            <ApprovalStatusDropdown :company="company" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
