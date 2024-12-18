<template>
  <div class="ml-60 space-y-5">
    <!-- Welcome Section -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
      <h1 class="text-2xl font-bold text-white">Welcome, <span class="text-[#00FFAB]">{{ auth.user.company_name }}</span>!</h1>
      <p class="text-white">Here’s an overview of your internship activities.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Total Applications -->
      <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
        <i class="fas fa-file-alt text-3xl text-[#00FFAB]"></i>
        <div>
          <h3 class="text-sm text-gray-600">TOTAL APPLICATIONS</h3>
          <p class="text-2xl font-bold text-gray-800">{{ totalApplications }}</p>
        </div>
      </div>

      <!-- Applications Under Review -->
      <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
        <i class="fas fa-clock text-3xl text-yellow-500"></i>
        <div>
          <h3 class="text-sm text-gray-600">APPLICATIONS UNDER REVIEW</h3>
          <p class="text-2xl font-bold text-gray-800">{{ underReviewApplications }}</p>
        </div>
      </div>

      <!-- Accepted Applications -->
      <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
        <i class="fas fa-check-circle text-3xl text-green-500"></i>
        <div>
          <h3 class="text-sm text-gray-600">ACCEPTED APPLICATIONS</h3>
          <p class="text-2xl font-bold text-gray-800">{{ acceptedApplications }}</p>
        </div>
      </div>

      <!-- Rejected Applications -->
      <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
        <i class="fas fa-times-circle text-3xl text-red-500"></i>
        <div>
          <h3 class="text-sm text-gray-600">REJECTED APPLICATIONS</h3>
          <p class="text-2xl font-bold text-gray-800">{{ rejectedApplicationsCount }}</p>
        </div>
      </div>
    </div>

    <!-- Graphs Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Applications Overview Chart -->
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Applications Overview</h2>
        <canvas ref="applicationsChart"></canvas>
      </div>

      <!-- Applications Status Distribution -->
      <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Status Distribution</h2>
        <canvas ref="statusChart"></canvas>
      </div>
    </div>

    <!-- Recent Applications -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
      <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Applications</h2>
      <div v-if="recentApplications.length > 0" class="space-y-4">
        <div
          v-for="application in recentApplications"
          :key="application.id"
          class="p-4 border border-gray-200 rounded-md flex justify-between items-center"
        >
          <div>
            <h3 class="text-lg font-semibold text-gray-800">
              {{ application.internship.internship_name }}
            </h3>
            <p class="text-sm text-gray-600">Applicant: {{ application.user.first_name }}</p>
            <p class="text-sm text-gray-600">Status: {{ application.status }}</p>
          </div>
          <div>
            <i
              :class="{
                'fas fa-clock text-yellow-500': application.status === 'under review',
                'fas fa-check-circle text-green-500': application.status === 'accepted',
                'fas fa-times-circle text-red-500': application.status === 'rejected',
              }"
              class="text-2xl"
            ></i>
          </div>
        </div>
      </div>
      <p v-else class="text-gray-500">No recent applications found.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Chart, registerables } from "chart.js";
import { usePage } from "@inertiajs/vue3";

// Register Chart.js components
Chart.register(...registerables);

// Destructure props passed from the controller
const {
  totalApplications,
  underReviewApplications,
  acceptedApplications,
  rejectedApplicationsCount,
  recentApplications,
  auth,
} = usePage().props;

// Chart References
const applicationsChart = ref(null);
const statusChart = ref(null);

// Initialize Charts on Mount
onMounted(() => {
  // Applications Overview Chart
  new Chart(applicationsChart.value, {
    type: "bar",
    data: {
      labels: ["Total", "Under Review", "Accepted", "Rejected"],
      datasets: [
        {
          label: "Applications",
          data: [
            totalApplications,
            underReviewApplications,
            acceptedApplications,
            rejectedApplicationsCount,
          ],
          backgroundColor: ["#00FFAB", "#F59E0B", "#10B981", "#EF4444"],
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { precision: 0 },
        },
      },
    },
  });

  // Status Distribution Chart
  new Chart(statusChart.value, {
    type: "pie",
    data: {
      labels: ["Under Review", "Accepted", "Rejected"],
      datasets: [
        {
          data: [
            underReviewApplications,
            acceptedApplications,
            rejectedApplicationsCount,
          ],
          backgroundColor: ["#F59E0B", "#10B981", "#EF4444"],
          hoverOffset: 8,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: "bottom" },
      },
    },
  });
});
</script>

<style>
/* Optional Custom Styling */
</style>
