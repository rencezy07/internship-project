<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

// Get the applications from the page props
const { applications, applicationSummary } = usePage().props;

// Reactive variable for the selected filter
const selectedFilter = ref('all');

// Computed property to filter applications
const filteredApplications = computed(() => {
  if (selectedFilter.value === 'all') {
    return applications;
  }
  return applications.filter(app => app.status === selectedFilter.value);
});
</script>

<template>
  <div>
    <h1 class="text-2xl font-semibold mb-6">My Applications</h1>


    <!-- Filter Dropdown -->
    <div class="mb-6">
      <label for="filter" class="block text-sm font-medium text-gray-700 mb-2">
        Filter by Status:
      </label>
      <select
        id="filter"
        v-model="selectedFilter"
        class="block w-full max-w-xs border border-gray-300 rounded-lg px-4 py-2 bg-white text-sm"
      >
        <option value="all">All</option>
        <option value="under review">Under Review</option>
        <option value="accepted">Accepted</option>
        <option value="rejected">Rejected</option>
      </select>
    </div>

     <!-- Summary Statistics -->
     <div v-if="applicationSummary.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <div class="bg-white p-4 rounded shadow text-center">
        <h3 class="text-sm font-semibold text-gray-500">Total Applications</h3>
        <p class="text-xl font-bold text-blue-500">{{ applicationSummary[0].total_applications }}</p>
      </div>
      <div class="bg-white p-4 rounded shadow text-center">
        <h3 class="text-sm font-semibold text-gray-500">Under Review</h3>
        <p class="text-xl font-bold text-yellow-500">{{ applicationSummary[0].under_review_count }}</p>
      </div>
      <div class="bg-white p-4 rounded shadow text-center">
        <h3 class="text-sm font-semibold text-gray-500">Accepted</h3>
        <p class="text-xl font-bold text-green-500">{{ applicationSummary[0].accepted_count }}</p>
      </div>
      <div class="bg-white p-4 rounded shadow text-center">
        <h3 class="text-sm font-semibold text-gray-500">Rejected</h3>
        <p class="text-xl font-bold text-red-500">{{ applicationSummary[0].rejected_count }}</p>
      </div>
    </div>

    <!-- Displaying applications -->
    <div v-if="filteredApplications.length === 0" class="text-gray-500">
      No applications found.
    </div>

    <div v-else>
      <ul>
        <!-- Loop through filtered applications -->
        <li
          v-for="application in filteredApplications"
          :key="application.id"
          class="mb-4 p-4 border border-gray-200 rounded-lg"
        >
          <div class="flex justify-between items-center">
            <div>
              <!-- Check if internship exists before trying to access internship_name -->
              <h3 v-if="application.internship" class="font-semibold">
                {{ application.internship.internship_name }}
              </h3>
              <p class="text-sm text-gray-500">Applied on: {{ application.created_at }}</p>
            </div>

            <!-- Status -->
            <span
              :class="{
                'text-yellow-500': application.status === 'under review',
                'text-green-500': application.status === 'accepted',
                'text-red-500': application.status === 'rejected',
              }"
              class="font-medium"
            >
              {{ application.status }}
            </span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>
