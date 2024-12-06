<script setup>
import { Link } from '@inertiajs/vue3';  // Ensure Link is imported
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const page = usePage();
const admin = computed(() => page.props.auth.user);  // Check if the user is an admin
</script>

<template>
  <div class="flex h-screen" >
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col" v-if="admin">
    aa
      <div class="p-4 text-lg font-bold border-b border-gray-700">Admin Panels</div>
      <nav class="flex-grow">
        <ul>
          <li class="p-4 hover:bg-gray-700">
            <a href="/admin/dashboard" class="block hover:bg-gray-700">Dashboard</a>
            <a href="/admin/company-applications" class="block hover:bg-gray-700">Companies Application</a>
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
    </aside>

    <!-- Main Content -->
    <div>
    <main class="flex-grow p-6 bg-gray-100" >
      <!-- Slot for main content -->
      <slot />
    </main>
  </div>
  </div>
</template>
