<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

// Get applications and summary data
const { applications, applicationSummary } = usePage().props;

// Reactive variable for the selected filter
const selectedFilter = ref("all");

// Compute totals dynamically
const summary = computed(() => {
    const totals = {
        total: 0,
        underReview: 0,
        accepted: 0,
        rejected: 0,
    };

    applicationSummary.forEach((row) => {
        totals.total += row.total_applications || 0;
        totals.underReview += row.under_review_count || 0;
        totals.accepted += row.accepted_count || 0;
        totals.rejected += row.rejected_count || 0;
    });

    return totals;
});

// Filtered applications
const filteredApplications = computed(() => {
    if (selectedFilter.value === "all") return applications;
    return applications.filter((app) => app.status === selectedFilter.value);
});
</script>

<template>
    <div class="p-6 max-w-7xl mx-auto bg-gray-50 min-h-screen">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-wide">
                <i class="fas fa-briefcase text-[#00FFAB] mr-2"></i> My
                Applications
            </h1>
        </div>

        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Applications -->
            <div
                class="p-6 bg-white rounded-xl shadow-lg flex flex-col items-center transition-transform hover:scale-105"
            >
                <i class="fas fa-list text-4xl text-[#00FFAB] mb-3"></i>
                <h3 class="text-lg font-semibold text-gray-500">
                    Total Applications
                </h3>
                <p class="text-3xl font-extrabold text-[#00FFAB] mt-2">
                    {{ summary.total }}
                </p>
            </div>

            <!-- Under Review -->
            <div
                class="p-6 bg-white rounded-xl shadow-lg flex flex-col items-center transition-transform hover:scale-105"
            >
                <i
                    class="fas fa-hourglass-half text-4xl text-yellow-500 mb-3"
                ></i>
                <h3 class="text-lg font-semibold text-gray-500">
                    Under Review
                </h3>
                <p class="text-3xl font-extrabold text-yellow-500 mt-2">
                    {{ summary.underReview }}
                </p>
            </div>

            <!-- Accepted -->
            <div
                class="p-6 bg-white rounded-xl shadow-lg flex flex-col items-center transition-transform hover:scale-105"
            >
                <i class="fas fa-check-circle text-4xl text-green-500 mb-3"></i>
                <h3 class="text-lg font-semibold text-gray-500">Accepted</h3>
                <p class="text-3xl font-extrabold text-green-500 mt-2">
                    {{ summary.accepted }}
                </p>
            </div>

            <!-- Rejected -->
            <div
                class="p-6 bg-white rounded-xl shadow-lg flex flex-col items-center transition-transform hover:scale-105"
            >
                <i class="fas fa-times-circle text-4xl text-red-500 mb-3"></i>
                <h3 class="text-lg font-semibold text-gray-500">Rejected</h3>
                <p class="text-3xl font-extrabold text-red-500 mt-2">
                    {{ summary.rejected }}
                </p>
            </div>
        </div>

        <!-- Applications Filter -->
        <div class="flex items-center justify-center mb-8">
            <label for="filter" class="sr-only">Filter by Status</label>
            <select
                id="filter"
                v-model="selectedFilter"
                class="w-full max-w-xs px-4 py-2 rounded-lg border border-gray-300 text-gray-700 focus:ring-2 focus:ring-[#00FFAB] focus:outline-none"
            >
                <option value="all">All</option>
                <option value="under review">Under Review</option>
                <option value="accepted">Accepted</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <!-- Applications List -->
        <div
            v-if="filteredApplications.length === 0"
            class="text-center text-gray-500 text-lg"
        >
            <i class="fas fa-folder-open text-6xl text-gray-300 mb-3"></i>
            <p>No applications found.</p>
        </div>

        <ul v-else class="space-y-4">
            <li
                v-for="application in filteredApplications"
                :key="application.id"
                class="p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow flex justify-between items-center"
            >
                <div class="flex items-center gap-4">
                    <i
                        class="fas fa-file-alt text-3xl text-[#00FFAB]"
                        aria-hidden="true"
                    ></i>
                    <div>
                        <h3
                            v-if="application.internship"
                            class="text-lg font-bold text-gray-800"
                        >
                            {{ application.internship.internship_name }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Applied on:
                            <span class="font-medium text-gray-600">{{
                                application.created_at
                            }}</span>
                        </p>
                    </div>
                </div>
                <span
                    :class="{
                        'text-yellow-500 bg-yellow-100 px-3 py-1 rounded-lg':
                            application.status === 'under review',
                        'text-green-500 bg-green-100 px-3 py-1 rounded-lg':
                            application.status === 'accepted',
                        'text-red-500 bg-red-100 px-3 py-1 rounded-lg':
                            application.status === 'rejected',
                    }"
                    class="text-sm font-semibold"
                >
                    {{ application.status }}
                </span>
            </li>
        </ul>
    </div>
</template>

<style scoped>
/* Smooth hover and transition effects */
.transition-transform {
    transition: transform 0.3s ease-in-out;
}

.transition-shadow {
    transition: box-shadow 0.3s ease-in-out;
}

.hover\:scale-105:hover {
    transform: scale(1.05);
}
</style>
