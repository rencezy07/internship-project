<script setup>
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const isSidebarOpen = ref(false);
const isDropdownOpen = ref(false);

const toggleSidebar = () => (isSidebarOpen.value = !isSidebarOpen.value);
const toggleDropdown = () => (isDropdownOpen.value = !isDropdownOpen.value);

// Dynamically check if user is authenticated
const page = usePage();
const isAdminLoggedIn = computed(() => page.props.auth && page.props.auth.user);
</script>



<template>
  <div class="flex h-screen">
    <!-- Sidebar: Render only if user is logged in -->
    <aside
      v-if="isAdminLoggedIn"
      :class="['fixed top-0 left-0 h-full bg-gray-900 text-white w-64 transform lg:translate-x-0 transition-transform duration-300 z-50', {'-translate-x-full': !isSidebarOpen}]"
    >
      <!-- Sidebar Header -->
      <div class="text-black bg-gradient-to-r from-[#00FFAB] to-[#00C29A] flex items-center justify-between p-6 border-b border-gray-700">
        <div class="text-xl font-extrabold flex items-center space-x-2">
          <i class="fas fa-user-shield text-gray-900"></i>
          <span>Admin Panel</span>
        </div>
        <button @click="toggleSidebar" class="lg:hidden text-gray-400 hover:text-white">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <!-- Navigation Links -->
      <nav class="mt-6">
        <ul class="space-y-2">
          <li>
            <Link href="/admin/dashboard" class="flex items-center px-6 py-3 hover:bg-gray-700 rounded-md transition">
              <i class="fas fa-tachometer-alt text-[#00FFAB] mr-2"></i> Dashboard
            </Link>
          </li>

<!-- Company Applications -->
<li>
              <a href="/admin/company-applications" class="flex items-center px-6 py-3 hover:bg-gray-700 rounded-md transition">
                <i class="fas fa-briefcase text-[#00FFAB] mr-2"></i>
                Company Applications
              </a>
            </li>
  
            <!-- Student Applications -->
            <li>
              <a href="/admin/student-internship-applications" class="flex items-center px-6 py-3 hover:bg-gray-700 rounded-md transition">
                <i class="fas fa-user-graduate text-[#00FFAB] mr-2"></i>
                Student Applications
              </a>
            </li>
  
            <!-- Activity Logs -->
            <li>
              <a href="/admin/activity-logs" class="flex items-center px-6 py-3 hover:bg-gray-700 rounded-md transition">
                <i class="fas fa-history text-[#00FFAB] mr-2"></i>
                Activity Logs
              </a>
            </li>
  
            <!-- Dropdown: Users -->
            <li>
              <div
                @click="toggleDropdown"
                class="flex items-center px-6 py-3 hover:bg-gray-700 cursor-pointer justify-between rounded-md transition"
              >
                <div class="flex items-center">
                  <i class="fas fa-users text-[#00FFAB] mr-2"></i>
                  Users
                </div>
                <i :class="{'rotate-180': isDropdownOpen}" class="fas fa-chevron-down transition-transform"></i>
              </div>
              <ul v-if="isDropdownOpen" class="ml-6 space-y-1 mt-1">
                <li>
                  <a href="/admin/view-users" class="block px-6 py-2 hover:bg-gray-600 rounded-md">
                    <i class="fas fa-user text-[#00FFAB] mr-2"></i> Students
                  </a>
                </li>
                <li>
                  <a href="/admin/view-companies" class="block px-6 py-2 hover:bg-gray-600 rounded-md">
                    <i class="fas fa-building text-[#00FFAB] mr-2"></i> Companies
                  </a>
                </li>
              </ul>
            </li>

          <li>
            <Link
              :href="route('admin.logout')"
              method="post"
              as="button"
              class="flex items-center px-6 py-3 text-left hover:bg-red-600 rounded-md w-full transition"
            >
              <i class="fas fa-sign-out-alt text-red-400 mr-2"></i> Logout
            </Link>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <div :class="['flex-1', isAdminLoggedIn ? 'ml-64' : 'ml-0']">
      <main class="p-6 bg-gray-100">
        <slot />
      </main>
    </div>
  </div>
</template>

