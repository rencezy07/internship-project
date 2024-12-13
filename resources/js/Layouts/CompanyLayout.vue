<script setup>
import { Link } from '@inertiajs/vue3'; // Ensure Link is imported
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

// Get the authenticated company user from props
const page = usePage();
const company = computed(() => page.props.auth.user); // Check if the user is authenticated
</script>

<template>
  <div class="flex flex-col h-screen">
    <!-- Top Navbar for Non-Authenticated Users -->
    <header v-if="!company" class="bg-gray-800 text-white py-4 shadow sticky top-0 z-50">
      <div class="container mx-auto flex justify-between items-center px-6">
        <h1 class="text-2xl font-bold">Welcome to Company Portal</h1>
        <nav>
          <ul class="flex space-x-4">
            <li>
              <Link
                :href="route('company.login')"
                class="px-4 py-2 hover:bg-gray-700 rounded-lg"
              >
                Login
              </Link>
            </li>
            <li>
              <Link
                :href="route('company.register')"
                class="px-4 py-2 hover:bg-gray-700 rounded-lg"
              >
                Register
              </Link>
            </li>
          </ul>
        </nav>
      </div>
    </header>

    <!-- Sidebar for Authenticated Users -->
    <div class="flex flex-grow">
      <aside
        v-if="company"
        class="w-64 bg-gray-800 text-white flex flex-col"
      >
        <div class="p-4 text-lg font-bold border-b border-gray-700">
          Company Panels
        </div>
        <nav class="flex-grow">
          <ul>
            <li>
              <Link
                :href="route('company.dashboard')"
                class="hover:bg-gray-700 px-4 py-2 rounded-lg"
              >
                Dashboard
              </Link>
            </li>
            <li>
              <Link
                :href="route('company.internships')"
                class="hover:bg-gray-700 px-4 py-2 rounded-lg"
              >
               Add Internship
              </Link>
            </li>
            <li>
              <Link
                :href="route('company.manageInternships')"
                class="hover:bg-gray-700 px-4 py-2 rounded-lg"
              >
                Manage Internships 
              </Link>
            </li>
            <li>
              <Link
  :href="route('company.manage-internships-application')"
  class="hover:bg-gray-700 px-4 py-2 rounded-lg"
>
  Manage All Internship Applications
</Link>
            </li>
            <li class="p-4 hover:bg-gray-700">
              <Link
                :href="route('company.logout')"
                method="post"
                as="button"
                class="block w-full px-6 py-3 hover:bg-slate-700 text-left"
              >
                Logout
              </Link>
            </li>
          </ul>
        </nav>
      </aside>

      <!-- Main Content -->
      <div
        :class="{
          'flex-grow p-6 bg-gray-100': true,
          'ml-64': company, // Add margin if sidebar is displayed
        }"
      >
        <main>
          <!-- Slot for main content -->
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>
