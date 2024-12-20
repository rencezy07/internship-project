<script setup>
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

// Get the authenticated company user from props
const page = usePage();
const company = computed(() => page.props.auth.user);
</script>

<template>
    <div class="flex flex-col h-screen bg-gray-50">
        <!-- Top Navbar for Non-Authenticated Users -->
        <header
            v-if="!company"
            class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-4 shadow sticky top-0 z-50"
        >
            <div
                class="container mx-auto flex justify-between items-center px-6"
            >
                <!-- Logo and Title -->
                <!-- Logo -->
                <Link :href="route('home')">
                    <img
                        src="/public/images/internship-logo.png"
                        alt="Logo"
                        class="h-12 w-15 object-cover"
                    />
                </Link>
                <h1 class="text-2xl font-bold">Welcome to Company Portal</h1>
                <nav>
                    <ul class="flex space-x-4">
                        <li>
                            <Link
                                :href="route('company.login')"
                                class="px-4 py-2 bg-[#00FFAB] text-black rounded hover:bg-[#00D294] transition"
                            >
                                Login
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('company.register')"
                                class="px-4 py-2 bg-[#00FFAB] text-black rounded hover:bg-[#00D294] transition"
                            >
                                Register
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Sidebar and Main Content -->
        <div class="h-screen">
            <!-- Sidebar -->
            <aside
                v-if="company"
                class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-gray-300 flex flex-col shadow-lg fixed h-full"
            >
                <!-- Sidebar Header -->
                <div
                    class="p-4 text-black text-xl font-extrabold bg-gradient-to-r from-[#00FFAB] to-[#00C29A] flex items-center justify-center shadow-md"
                >
                    <i class="fas fa-users text-black pr-2"></i>

                    Company Panel
                </div>

                <!-- Sidebar Navigation -->
                <nav class="flex-grow mt-4">
                    <ul class="space-y-2">
                        <!-- Dashboard -->
                        <li>
                            <Link
                                :href="route('company.dashboard')"
                                class="flex items-center px-6 py-3 hover:bg-[#00FFAB] hover:text-black transition duration-300 rounded-md"
                            >
                                <span class="mr-3">🏠</span>
                                <span>Dashboard</span>
                            </Link>
                        </li>
                        <!-- Add Internship -->
                        <li>
                            <Link
                                :href="route('company.internships')"
                                class="flex items-center px-6 py-3 hover:bg-[#00FFAB] hover:text-black transition duration-300 rounded-md"
                            >
                                <span class="mr-3">➕</span>
                                <span>Add Internship</span>
                            </Link>
                        </li>
                        <!-- Manage Internships -->
                        <li>
                            <Link
                                :href="route('company.manageInternships')"
                                class="flex items-center px-6 py-3 hover:bg-[#00FFAB] hover:text-black transition duration-300 rounded-md"
                            >
                                <span class="mr-3">🛠</span>
                                <span>Manage Internships</span>
                            </Link>
                        </li>
                        <!-- Manage Applications -->
                        <li>
                            <Link
                                :href="
                                    route(
                                        'company.manage-internships-application'
                                    )
                                "
                                class="flex items-center px-6 py-3 hover:bg-[#00FFAB] hover:text-black transition duration-300 rounded-md"
                            >
                                <span class="mr-3">📋</span>
                                <span>Manage Applications</span>
                            </Link>
                        </li>

                        <li>
                            <Link
                                :href="route('company.profile')"
                                class="flex items-center px-6 py-3 hover:bg-[#00FFAB] hover:text-black transition duration-300 rounded-md"
                            >
                                <span class="mr-3">🪪</span>
                                <span>Profile</span>
                            </Link>
                        </li>

                        <!-- Logout -->
                        <li>
                            <Link
                                :href="route('company.logout')"
                                method="post"
                                as="button"
                                class="flex items-center px-6 py-3 hover:bg-red-600 hover:text-white transition duration-300 text-left w-full rounded-md"
                            >
                                <span class="mr-3">🚪</span>
                                <span>Logout</span>
                            </Link>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex-grow p-6 bg-gray-100 overflow-y-auto">
                <main>
                    <!-- Slot for main content -->
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
