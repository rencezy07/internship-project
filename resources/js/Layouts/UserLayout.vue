<script setup>
import { Link } from '@inertiajs/vue3';  // Ensure Link is imported
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

// Get the user data from the page props (for logged-in user)
const page = usePage();
const user = computed(() => page.props.auth.user);  // Get the user object

// Track if the dropdown menu is open or closed
const isDropdownOpen = ref(false);

// Toggle the dropdown menu visibility
const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};
</script>

<template>
  <div>
    <!-- Navbar -->
    <nav class="bg-gray-800 text-white p-4">
      <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo or Title -->
        <div class="text-lg font-bold">User Panel</div>

        <!-- Navbar links -->
        <div class="flex space-x-4">
          <!-- Show Dashboard link if logged in, otherwise show Login link -->
        <p v-if="user"></p>
          <Link
            v-else
            :href="route('login')"
            class="hover:bg-gray-700 px-4 py-2 rounded-lg"
          >
            Login
          </Link>
        </div>

        <!-- User's name or Logout if logged in -->
        <div class="flex items-center space-x-4">
          <!-- Display user's name if logged in, and add a dropdown when clicked -->
          <div v-if="user" class="relative">
            <button
              @click="toggleDropdown"
              class="text-sm hover:bg-gray-700 px-4 py-2 rounded-lg"
            >
              {{ user.name }}
            </button>

            <!-- Dropdown Menu -->
            <div v-if="isDropdownOpen" class="absolute right-0 mt-2 w-48 bg-white text-gray-900 rounded-lg shadow-lg">
              <ul>
                 <li>
                  <Link
                    :href="route('user.dashboard')"
                    class="block px-4 py-2 hover:bg-gray-200"
                  >
                    Home
                  </Link>
                  <Link
                    :href="route('user.application')"
                    class="block px-4 py-2 hover:bg-gray-200"
                  >
                    My Applications
                  </Link>
                  <Link
                    :href="route('user.logout')"
                      method="post"
                      as="button"
                    class="block px-4 py-2 hover:bg-gray-200"
                  >
                    Logout
                  </Link>

                </li>
                
                <!-- Settings link -->
                <!-- <li>
                  <Link
                    :href="route('user.settings')"
                    class="block px-4 py-2 hover:bg-gray-200"
                  >
                    Settings
                  </Link>
                </li> -->
                <!-- Logout link -->
                <!-- <li>
                
                </li> -->
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="p-6 bg-gray-100">
      <!-- Slot for main content -->
      <slot />
    </main>
  </div>
</template>
