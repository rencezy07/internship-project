<script setup>
import { Link } from "@inertiajs/vue3"; // Ensure Link is imported
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const highlightStatus = (message) => {
    // Ensure message is a valid string
    if (!message || typeof message !== "string") {
        return "No message available"; // Fallback message
    }

    // Check for status words and wrap them in a span with the corresponding class
    return message
        .replace(
            /(rejected)/gi,
            '<span class="text-red-700 font-bold italic">$1</span>'
        )
        .replace(
            /(accepted)/gi,
            '<span class="text-green-700 font-bold italic">$1</span>'
        )
        .replace(
            /(under review)/gi,
            '<span class="text-yellow-700 font-bold italic">$1</span>'
        );
};

const page = usePage();
const notificationCount = computed(() => page.props.notificationCount || 0); // Default to 0

// Get the user data from the page props (for logged-in user)
const user = computed(() => page.props.auth.user); // Get the user object
const notifications = computed(() => page.props.notifications || []); // Get notifications passed from backend

// Create a computed property that reverses the order of notifications
const sortedNotifications = computed(() => {
    return [...notifications.value].reverse(); // Spread operator to avoid mutation
});

// Track if the notification dropdown is open or closed
const isNotificationsOpen = ref(false); // Correctly initialize isNotificationsOpen

// Track if the dropdown menu is open or closed
const isDropdownOpen = ref(false);

const toggleNotifications = () => {
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
        <nav class="bg-white shadow-lg sticky top-0 z-50">
            <div
                class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center"
            >
                <!-- Logo and Title -->
                <div class="flex items-center space-x-3">
                    <!-- Logo -->
                    <Link :href="route('user.home')">
                        <img
                            src="/public/images/internship-logo.png"
                            alt="Logo"
                            class="h-12 w-15 object-cover"
                        />
                    </Link>
                </div>

                <!-- Navbar Links -->
                <div class="flex items-center space-x-6">
                    <!-- Login/Sign Up Links -->
                    <div v-if="!user" class="flex space-x-4">
                        <Link
                            :href="route('login')"
                            class="text-gray-700 hover:text-[#00FFAB] font-semibold transition duration-300"
                        >
                            Login
                        </Link>
                        <Link
                            :href="route('user.register')"
                            class="text-gray-700 hover:text-[#00FFAB] font-semibold transition duration-300"
                        >
                            Sign Up
                        </Link>
                    </div>

                    <!-- Notifications and User Dropdown -->
                    <div v-else class="flex items-center space-x-6 relative">
                        <!-- Notifications Icon -->
                        <button
                            @click="toggleNotifications"
                            class="relative focus:outline-none"
                        >
                            <i
                                class="fas fa-bell text-gray-600 hover:text-[#00FFAB] text-xl"
                            ></i>
                            <!-- Notification Count -->
                            <span
                                v-if="notificationCount > 0"
                                class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full h-4 w-4 flex items-center justify-center"
                            >
                                {{ notificationCount }}
                            </span>
                        </button>

                        <!-- Notifications Dropdown -->
                        <div
                            v-if="isNotificationsOpen"
                            class="absolute right-0 top-12 bg-white shadow-lg rounded-lg w-64 max-h-64 overflow-y-auto z-50"
                        >
                            <div class="p-4">
                                <h3 class="text-gray-800 font-bold mb-2">
                                    Notifications
                                </h3>
                                <ul class="space-y-2">
                                    <li
                                        v-if="notifications.length === 0"
                                        class="text-sm text-gray-500 text-center"
                                    >
                                        No messages yet.
                                    </li>
                                    <li
                                        v-for="notification in sortedNotifications"
                                        :key="notification.id"
                                        class="p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200"
                                    >
                                        <p
                                            class="text-sm text-gray-700 font-medium"
                                        >
                                            <span
                                                v-html="
                                                    highlightStatus(
                                                        notification.message
                                                    )
                                                "
                                            ></span>
                                        </p>
                                        <small class="text-xs text-gray-400">
                                            {{ notification.created_at }}
                                        </small>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- User Dropdown -->
                        <div
                            class="flex items-center space-x-2 cursor-pointer relative"
                        >
                            <!-- User Profile Image -->
                            <img
                                :src="`/storage/${user.profile_picture}`"
                                alt="User Profile"
                                class="h-10 w-10 rounded-full border-2 border-[#00FFAB]"
                            />

                            <!-- Dropdown Toggle -->
                            <button
                                @click="toggleDropdown"
                                class="text-gray-700 font-semibold hover:text-[#00FFAB] transition duration-300"
                            >
                                {{ user.first_name }}
                            </button>

                            <!-- Dropdown Menu -->
                            <div
                                v-if="isDropdownOpen"
                                class="absolute right-0 top-12 w-48 bg-white shadow-lg rounded-lg overflow-hidden z-50"
                            >
                                <ul>
                                    <li>
                                        <Link
                                            :href="route('user.home')"
                                            class="block px-4 py-2 hover:bg-gray-100 text-gray-700"
                                        >
                                            Home
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            :href="route('user.application')"
                                            class="block px-4 py-2 hover:bg-gray-100 text-gray-700"
                                        >
                                            My Applications
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            :href="route('user.profile')"
                                            class="block px-4 py-2 hover:bg-gray-100 text-gray-700"
                                        >
                                            My Profile
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            :href="route('user.logout')"
                                            method="post"
                                            as="button"
                                            class="block px-4 py-2 hover:bg-gray-100 text-red-500 font-semibold"
                                        >
                                            Logout
                                        </Link>
                                    </li>
                                </ul>
                            </div>
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
.notifications-dropdown::-webkit-scrollbar {
    width: 8px; 
    height: 8px; 
}

.notifications-dropdown::-webkit-scrollbar-thumb {
    background-color: #4b5563; 
    border-radius: 10px; 
    border: 2px solid #d1d5db; 
}

.notifications-dropdown::-webkit-scrollbar-track {
    background: #f3f4f6; 
    border-radius: 10px; 
}
</style>
