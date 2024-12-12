<template>
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col" v-if="admin">
      <div class="p-4 text-lg font-bold border-b border-gray-700">Admin Panels</div>
      <nav class="flex-grow">
        <ul>
          <!-- Dashboard Link -->
          <li class="p-4 hover:bg-gray-700">
            <a href="/admin/dashboard" class="block">Dashboard</a>
          </li>

          <!-- Company Applications Link -->
          <li class="p-4 hover:bg-gray-700">
            <a href="/admin/company-applications" class="block">Company Applications</a>
          </li>

        
          <li class="p-4 hover:bg-gray-700">
  <a href="/admin/student-internship-applications" class="block">Student Internship Applications</a>
</li>


          <!-- Users Dropdown -->
          <li>
            <div
              class="p-4 hover:bg-gray-700 cursor-pointer flex justify-between items-center"
              @click="toggleDropdown"
            >
              <span>Users</span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                :class="{'rotate-180': isDropdownOpen, 'rotate-0': !isDropdownOpen}"
                class="h-5 w-5 transform transition-transform"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
            <ul
              v-if="isDropdownOpen"
              class="bg-gray-700 text-sm"
            >
              <li class="p-4 hover:bg-gray-600">
                <a href="/admin/view-users" class="block">Students</a>
              </li>
              <li class="p-4 hover:bg-gray-600">
                <a href="/admin/view-companies" class="block">Companies</a>
              </li>
            </ul>
          </li>

          <li>
            <Link
          :href="route('admin.logout')"
          method="post"
          as="button"
          class="block w-full px-6 py-3 hover:bg-slate-700 text-left"
        >
          Logout
        </Link>
          </li>
        </ul>
      </nav>

      <!-- Logout Link -->
      <div class="p-4 border-t border-gray-700">
       
      </div>
    </aside>

    <!-- Main Content -->
    <div>
      <main class="flex-grow p-6 bg-gray-100">
        <!-- Slot for main content -->
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const page = usePage();
const admin = computed(() => page.props.auth.user); // Check if the user is an admin

// State for dropdown toggle
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value; // Toggle dropdown visibility
};
</script>
