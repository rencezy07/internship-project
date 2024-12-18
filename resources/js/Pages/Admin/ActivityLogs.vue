<template>
    <div class="min-h-screen bg-white text-black p-4">
      <!-- Page Title -->
      <div class="flex flex-col items-center mb-6">
        <h1 class="text-3xl font-bold tracking-wide uppercase flex items-center gap-2">
          <i class="fas fa-tasks text-[#00FFAB]"></i> Activity Logs
        </h1>
        <p class="text-gray-500 text-sm mt-1">Track all system activities and actions performed</p>
      </div>
  
      <!-- Filters Section -->
      <div class="bg-white border border-gray-300 rounded-lg p-4 mb-6 shadow-md">
        <h2 class="text-lg font-semibold mb-4">Filters</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="relative">
            <input v-model="filters.user_type" placeholder="User Type" class="filter-input pl-10" />
          </div>
          <div class="relative">
            <input v-model="filters.user_id" placeholder="User ID" class="filter-input pl-10" />
          </div>
          <div class="relative">
            <input v-model="filters.company_id" placeholder="Company ID" class="filter-input pl-10" />
          </div>
          <div class="relative">
            <input
              v-model="filters.action_performed"
              placeholder="Action"
              class="filter-input pl-10"
            />
          </div>
          <input v-model="filters.table_name" placeholder="Table Name" class="filter-input" />
          <input v-model="filters.column_name" placeholder="Column Name" class="filter-input" />
          <input type="date" v-model="filters.date" class="filter-input" />
          <button
            @click="applyFilters"
            class="bg-[#00FFAB] text-black font-semibold px-4 py-2 rounded hover:scale-105 transition duration-300 shadow-md"
          >
            <i class="fas fa-filter mr-2"></i> Apply Filters
          </button>
        </div>
      </div>
  
      <!-- Logs Table -->
      <div class="overflow-x-auto">
        <table class="w-full border-collapse text-sm shadow-md">
          <thead class="bg-[#00FFAB] text-black uppercase">
            <tr>
              <th class="px-4 py-2 border">#</th>
              <th class="px-4 py-2 border">User Type</th>
              <th class="px-4 py-2 border">User ID</th>
              <th class="px-4 py-2 border">Company ID</th>
              <th class="px-4 py-2 border">Action</th>
              <th class="px-4 py-2 border">Table</th>
              <th class="px-4 py-2 border">Columns Changed</th>
              <th class="px-4 py-2 border">Timestamp</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(log, index) in activityLogs.data"
              :key="log.id"
              class="hover:bg-gray-100 transition"
            >
              <td class="px-4 py-2 border text-center">{{ index + 1 }}</td>
              <td class="px-4 py-2 border text-center">{{ log.user_type }}</td>
              <td class="px-4 py-2 border text-center">{{ log.user_id || "N/A" }}</td>
              <td class="px-4 py-2 border text-center">{{ log.company_id || "N/A" }}</td>
              <td class="px-4 py-2 border text-center">{{ log.action_performed }}</td>
              <td class="px-4 py-2 border text-center">{{ log.table_name }}</td>
              <td class="px-4 py-2 border text-center">{{ log.column_name || "N/A" }}</td>
              <td class="px-4 py-2 border text-center">
                <i class="fas fa-clock text-[#00FFAB] mr-1"></i>
                {{ new Date(log.created_at).toLocaleString() }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Pagination -->
      <div class="flex justify-between mt-6">
        <button
          v-if="activityLogs.prev_page_url"
          @click="fetchPage(activityLogs.prev_page_url)"
          class="pagination-button"
        >
          <i class="fas fa-chevron-left mr-2"></i> Previous
        </button>
        <button
          v-if="activityLogs.next_page_url"
          @click="fetchPage(activityLogs.next_page_url)"
          class="pagination-button"
        >
          Next <i class="fas fa-chevron-right ml-2"></i>
        </button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { defineProps, reactive } from "vue";
  import { router } from "@inertiajs/vue3";
  
  const props = defineProps({
    activityLogs: Object,
    filters: Object,
  });
  
  const filters = reactive({ ...props.filters });
  
  function applyFilters() {
    router.get(route("admin.activity-logs"), filters, { preserveState: true });
  }
  
  function fetchPage(url) {
    router.visit(url, { preserveState: true });
  }
  </script>
  
  <!-- Scoped Styles -->
  <style scoped>
  .filter-input {
    @apply w-full bg-gray-100 border border-gray-300 text-black px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-[#00FFAB] transition duration-200;
  }
  
  .pagination-button {
    @apply bg-[#00FFAB] text-black font-medium px-4 py-2 rounded-lg hover:scale-105 transition-transform duration-300 shadow-md;
  }
  
  table th,
  table td {
    @apply text-black text-center border border-gray-300;
  }
  </style>
  
  <!-- Import FontAwesome for Icons -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  />
  