<script setup>
import { usePage } from '@inertiajs/vue3';
import ApprovalStatusDropdown from '@/Components/ApprovalStatusDropdown.vue';  // Import the dropdown component

// Get companies from Inertia props
const { companies } = usePage().props;
</script>

<template>
  <div>
    <h1 class="text-xl font-bold">Company Applications</h1>

    <!-- Table for displaying companies -->
    <table class="min-w-full mt-4">
      <thead>
        <tr>
          <th class="px-4 py-2">Company Name</th>
          <th class="px-4 py-2">Email</th>
          <th class="px-4 py-2">Approval Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="company in companies" :key="company.id">
          <td class="px-4 py-2">{{ company.company_name }}</td>
          <td class="px-4 py-2">{{ company.email }}</td>
          <td class="px-4 py-2">
            <!-- Use the ApprovalStatusDropdown component for each company -->
            <ApprovalStatusDropdown :company="company" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
