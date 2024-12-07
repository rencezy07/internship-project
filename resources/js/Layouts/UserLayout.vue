<script setup>
import { Link } from "@inertiajs/vue3"; // Ensure Link is imported
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";


const highlightStatus = (message) => {
  // Check for status words and wrap them in a span with the corresponding class
  return message
    .replace(/(rejected)/gi, '<span class="text-red-700 font-bold italic">$1</span>')
    .replace(/(accepted)/gi, '<span class="text-green-700 font-bold italic">$1</span>')
    .replace(/(under review)/gi, '<span class="text-yellow-700 font-bold italic">$1</span>');
};


// Get the user data from the page props (for logged-in user)
const page = usePage();
const user = computed(() => page.props.auth.user); // Get the user object
const notifications = computed(() => page.props.notifications || []); // Get notifications passed from backend

// Create a computed property that reverses the order of notifications
const sortedNotifications = computed(() => {
  return [...notifications.value].reverse(); // Spread operator to avoid mutation
});

console.log("Notifications:", notifications.value);

// Track if the notification dropdown is open or closed
const isNotificationsOpen = ref(false); // Correctly initialize isNotificationsOpen

// Track if the dropdown menu is open or closed
const isDropdownOpen = ref(false);

const toggleNotifications = () => {
    console.log("Notifications clicked", notifications.value); // Check notifications value on click

    isNotificationsOpen.value = !isNotificationsOpen.value;
};

// Toggle the dropdown menu visibility
const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};
</script>

<template>
  <div>
    <!-- Navbar -->
    <nav class="bg-gray-800 text-white p-4 sticky top-0 z-50">
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
            <!-- Notifications Icon Button Start -->
            <button @click="toggleNotifications" class="relative">
              <span class="text-white px-4 py-2 rounded-lg">
                <!-- Notification Bell Icon -->
                <i class="fa fa-bell"></i>
              </span>
            </button>
            <!-- Notifications Icon Button End -->
            <button
              @click="toggleDropdown"
              class="text-sm hover:bg-gray-700 px-4 py-2 rounded-lg"
            >
              {{ user.name }}
            </button>

            <!-- Notifications Dropdown Start -->
            <div
              v-if="isNotificationsOpen"
              class="absolute top-16 right-4 bg-white text-black shadow-lg mt-2 rounded-lg w-64 max-h-64 overflow-y-auto notifications-dropdown"
            >
              <div class="p-4">
                <!-- Check if there are notifications -->
                <div class="font-semibold text-lg mb-2">Notifications</div>
                <ul class="space-y-2">
                  <!-- If no notifications -->
                  <li
                    v-if="notifications.length === 0"
                    class="px-4 py-2 text-gray-500 border-b border-gray-300"
                  >
                    No messages yet
                  </li>
                  <!-- If there are notifications -->
                  <li
                    v-for="notification in sortedNotifications"
                    :key="notification.id"
                    class="px-4 py-3 bg-gray-50 rounded-lg shadow-sm hover:bg-gray-100 border-b border-gray-300"
                  >
                    <p class="text-sm font-medium">
                      <span v-html="highlightStatus(notification.message)"></span>
                    </p>
                    <small class="text-xs text-gray-500">{{
                                            notification.created_at
                    }}</small>
                  </li>
                </ul>
              </div>
            </div>
            <!-- Notifications Dropdown End -->

            <!-- Dropdown Menu -->
            <div
              v-if="isDropdownOpen"
              class="absolute right-0 mt-2 w-48 bg-white text-gray-900 rounded-lg shadow-lg"
            >
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
    <main class="p-6 bg-gray-100" style="position: sticky; top: 0">
      <!-- Slot for main content -->
      <slot />
      <!--  user dashboard -->
    </main>
  </div>
</template>

<style scoped>
/* Custom scrollbar styling for WebKit browsers (Chrome, Safari, Edge) */
.notifications-dropdown::-webkit-scrollbar {
  width: 8px; /* Adjust width of the scrollbar */
  height: 8px; /* Adjust height of the scrollbar (for horizontal scrolling) */
}

.notifications-dropdown::-webkit-scrollbar-thumb {
  background-color: #4b5563; /* Color of the scrollbar handle */
  border-radius: 10px; /* Round the corners of the scrollbar */
  border: 2px solid #d1d5db; /* Optional: add border around the handle */
}

.notifications-dropdown::-webkit-scrollbar-track {
  background: #f3f4f6; /* Light background for the track */
  border-radius: 10px; /* Round the corners of the scrollbar track */
}
</style>
