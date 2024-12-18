<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <!-- Page Title -->
    <h1 class="text-4xl font-extrabold text-gray-800 mb-8">Admin Dashboard</h1>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 mb-8">
      <div
        v-for="stat in stats"
        :key="stat.id"
        class="p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-transform transform hover:scale-105"
      >
        <div class="flex items-center space-x-4">
          <div
            class="p-4 rounded-full"
            :class="stat.iconBg"
          >
            <i :class="stat.icon"></i>
          </div>
          <div>
            <h2 class="text-lg font-semibold text-gray-700">{{ stat.label }}</h2>
            <p class="text-3xl font-bold" :class="stat.textColor">{{ stat.value }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
      <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Applications Overview</h2>
        <canvas ref="applicationsChart"></canvas>
      </div>

      <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Users and Companies</h2>
        <canvas ref="usersChart"></canvas>
      </div>

      <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">User Signups Over Time</h2>
        <canvas ref="lineChart"></canvas>
      </div>

      <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Application Status Distribution</h2>
        <canvas ref="pieChart"></canvas>
      </div>
    </div>

    <!-- Recent Users and Companies -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-semibold text-[#00FFAB] mb-4">Recent Users</h2>
        <ul>
          <li
            v-for="user in recentUsers"
            :key="user.id"
            class="flex justify-between items-center mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition"
          >
            <div>
              <p class="font-medium text-gray-800">{{ user.first_name }} {{ user.last_name }}</p>
              <p class="text-sm text-gray-500">{{ user.email }}</p>
            </div>
            <div>
              <i class="fas fa-user-circle text-indigo-500 text-2xl"></i>
            </div>
          </li>
        </ul>
      </div>

      <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-semibold text-[#00FFAB] mb-4">Recent Companies</h2>
        <ul>
          <li
            v-for="company in recentCompanies"
            :key="company.id"
            class="flex justify-between items-center mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition"
          >
            <div>
              <p class="font-medium text-gray-800">{{ company.company_name }}</p>
              <p class="text-sm text-gray-500">{{ company.email }}</p>
            </div>
            <div>
              <i class="fas fa-building text-green-500 text-2xl"></i>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { usePage } from '@inertiajs/vue3';


import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

// Props
const props = defineProps({
  totalUsers: Number,
  totalCompanies: Number,
  totalApplications: Number,
  verifiedCompanies: Number,
  underReviewApplications: Number,
  userTrends: Array,
  statusSummary: Array,
});

const {

recentUsers = [],
recentCompanies = []
} = usePage().props;

// Dynamic Stats Cards
const stats = [
  {
    id: 1,
    label: "Total Users",
    value: props.totalUsers,
    icon: "fas fa-users fa-2x",
    iconBg: "bg-blue-100 text-blue-600",
    textColor: "text-blue-600",
  },
  {
    id: 2,
    label: "Total Companies",
    value: props.totalCompanies,
    icon: "fas fa-building fa-2x",
    iconBg: "bg-green-100 text-green-600",
    textColor: "text-green-600",
  },
  {
    id: 3,
    label: "Total Applications",
    value: props.totalApplications,
    icon: "fas fa-file-alt fa-2x",
    iconBg: "bg-yellow-100 text-yellow-600",
    textColor: "text-yellow-600",
  },
  {
    id: 4,
    label: "Verified Companies",
    value: props.verifiedCompanies,
    icon: "fas fa-check-circle fa-2x",
    iconBg: "bg-indigo-100 text-indigo-600",
    textColor: "text-indigo-600",
  },
];

// Charts Initialization
const applicationsChart = ref(null);
const usersChart = ref(null);
const lineChart = ref(null);
const pieChart = ref(null);

onMounted(() => {
// Applications Chart (Doughnut)
new Chart(applicationsChart.value, {
    type: 'doughnut',
    data: {
      labels: ['Verified Companies', 'Pending Applications', 'Total Applications'],
      datasets: [
        {
          data: [props.verifiedCompanies, props.underReviewApplications, props.totalApplications],
          backgroundColor: ['#10B981', '#F59E0B', '#6366F1'],
          hoverOffset: 8,
        },
      ],
    },
    options: {
      plugins: {
        legend: { display: true, position: 'bottom' },
      },
    },
  });
  
  // Users and Companies Chart (Bar)
  new Chart(usersChart.value, {
    type: 'bar',
    data: {
      labels: ['Users', 'Companies'],
      datasets: [
        {
          label: 'Count',
          data: [props.totalUsers, props.totalCompanies],
          backgroundColor: ['#34D399', '#60A5FA'],
          borderColor: ['#059669', '#2563EB'],
          borderWidth: 1,
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
  

// Line Chart for User Signups
if (props.userTrends && props.userTrends.length > 0) {
    new Chart(lineChart.value, {
      type: 'line',
      data: {
        labels: props.userTrends.map((trend) => trend.month),
        datasets: [
          {
            label: 'User Signups',
            data: props.userTrends.map((trend) => trend.total),
            borderColor: '#4F46E5',
            backgroundColor: 'rgba(79, 70, 229, 0.2)',
            fill: true,
            tension: 0.4, // Smooth the curve
          },
        ],
      },
      options: {
        responsive: true,
        scales: {
          x: { title: { display: true, text: 'Month' } },
          y: { beginAtZero: true, title: { display: true, text: 'Signups' } },
        },
      },
    });
  } else {
    console.warn("No user trends data available for the line chart.");
  }

  //PIE CHART--------------
  if (props.statusSummary && props.statusSummary.length > 0) {
    new Chart(pieChart.value, {
      type: "pie",
      data: {
        labels: props.statusSummary.map((status) => status.status), // Application statuses
        datasets: [
          {
            data: props.statusSummary.map((status) => status.total), // Count of each status
            backgroundColor: ["#10B981", "#F59E0B", "#EF4444"], // Colors for statuses
            hoverOffset: 8,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: true, position: "bottom" },
        },
      },
    });
  } else {
    console.warn("No data available for Application Status.");
  }

  });
</script>

<style>
/* Optional Custom Styling */
</style>
