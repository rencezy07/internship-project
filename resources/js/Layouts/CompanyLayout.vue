<script setup>
import { Link } from '@inertiajs/vue3';  // Ensure Link is imported
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const company = computed(() => page.props.auth.user);  // Check if the user is an admin
</script>

<template>
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col" v-if="company">
      <div class="p-4 text-lg font-bold border-b border-gray-700">Company Panels</div>
      <nav class="flex-grow">
        <ul>
          <li class="p-4 hover:bg-gray-700">
            <a href="/company/dashboard" class="block hover:bg-gray-700">Dashboard</a>
          </li>
          <li class="p-4 hover:bg-gray-700">
            <a href="/company/internships" class="block hover:bg-gray-700">Add Internships</a>
          </li>
          <li class="p-4 hover:bg-gray-700">
            <a href="/company/manage-internships" class="block hover:bg-gray-700">Manage Applicants</a>
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
    <div>
      <main class="flex-grow p-6 bg-gray-100">
        <!-- Slot for main content -->
        <slot />
      </main>
    </div>
  </div>
</template>
