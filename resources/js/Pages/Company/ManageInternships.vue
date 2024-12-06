<script setup>
import { usePage } from '@inertiajs/vue3';
import StatusUpdateDropdown from '@/Components/StatusUpdateDropdown.vue'; // Import the dropdown component

// Get the internships and their applications from Inertia props
const { internships } = usePage().props;
</script>

<template>
  <div>
    <h1 class="text-xl font-bold">Manage Internship Applications</h1>

    <div v-for="internship in internships" :key="internship.id">
      <h3 class="mt-4 text-lg font-semibold">{{ internship.internship_name }}</h3>
      <ul>
        <li v-for="application in internship.applications" :key="application.id" class="mt-2 p-2 border-b border-gray-300">
          <div class="flex justify-between">
            <span>{{ application.user.name }} - {{ application.user.email }}</span>
            <!-- Use the StatusUpdateDropdown component for each application -->
            <StatusUpdateDropdown :application="application" />
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>
