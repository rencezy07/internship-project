<script setup>
import { usePage } from '@inertiajs/vue3';

// Get the applications from the page props
const { applications } = usePage().props;
</script>

<template>
  <div>
    <h1 class="text-2xl font-semibold mb-6">My Applications</h1>

    <!-- Displaying applications -->
    <div v-if="applications.length === 0" class="text-gray-500">
      No applications found.
    </div>

    <div v-else>
      <ul>
        <!-- Loop through each application -->
        <li
          v-for="application in applications"
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
