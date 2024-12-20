<script setup>
import { usePage } from "@inertiajs/vue3";
import StatusUpdateDropdown from "@/Components/StatusUpdateDropdown.vue"; // Import the dropdown component

// Get the internships and their applications from Inertia props
const { internships } = usePage().props;
console.log(internships); // Log to check the structure of internships and their applications

const reloadInternships = () => {
    Inertia.reload({
        only: ["internships"],
        onSuccess: () => console.log("Internships reloaded"),
    });
};

</script>



<template>
    <div class="ml-60 max-w-7xl mx-auto p-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <h1
                class="text-4xl font-extrabold text-gray-800 tracking-wide drop-shadow-lg"
            >
                <i class="fas fa-briefcase text-[#00FFAB] mr-2"></i>
                Manage Internship Applications
            </h1>
        </div>

        <!-- Internship Applications List -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div
                v-for="internship in internships"
                :key="internship.internship_id"
                class="relative bg-white bg-opacity-70 backdrop-blur-lg rounded-2xl shadow-2xl p-6 hover:scale-105 transition-transform duration-300"
            >
                <!-- Decorative Glass Top Border -->
                <div
                    class="absolute top-0 left-0 w-full h-2 rounded-t-2xl bg-gradient-to-r from-[#00FFAB] to-[#00E6A0]"
                ></div>

                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800 truncate">
                        {{ internship.internship_name }}
                    </h3>
                    <span
                        class="px-3 py-1 text-xs font-semibold text-white rounded-full"
                        :class="{
                            'bg-green-500':
                                internship.application_status === 'Accepted',
                            'bg-yellow-500':
                                internship.application_status === 'Pending',
                            'bg-red-500':
                                internship.application_status === 'Rejected',
                        }"
                    >
                        {{ internship.application_status }}
                    </span>
                </div>

                <!-- Internship Details -->
                <div class="text-gray-600 space-y-2 mb-4">
                    <p class="text-sm">
                        <i class="fas fa-hashtag text-[#00FFAB] mr-2"></i>
                        Internship ID:
                        <span class="font-medium">{{
                            internship.internship_id
                        }}</span>
                    </p>
                    <p class="text-sm">
                        <i class="fas fa-id-card text-[#00FFAB] mr-2"></i>
                        Application ID:
                        <span class="font-medium">{{
                            internship.application_id
                        }}</span>
                    </p>
                    <p class="text-sm">
                        <i class="fas fa-user text-[#00FFAB] mr-2"></i>
                        Applicant:
                        <span class="font-medium">{{
                            internship.first_name
                        }}</span>
                    </p>
                    <p class="text-sm">
                        <i class="fas fa-user text-[#00FFAB] mr-2"></i>
                        Address:
                        <span class="font-medium">{{
                            internship.city
                        }}</span>
                    </p>
                </div>

                <!-- Applicant Profile and Documents -->
                <div class="flex items-center gap-4 mb-4">
                    <!-- Profile Picture -->
                    <img
                        :src="`/storage/${internship.profile_picture}`"
                        alt="Applicant Picture"
                        class="h-16 w-16 rounded-full border-2 border-[#00FFAB] object-cover shadow-lg"
                    />

                    <!-- Resume and Cover Letter Links -->
                    <div class="flex flex-col space-y-1">
                        <a
                            v-if="internship.resume"
                            :href="
                                route('company.download', {
                                    type: 'resume',
                                    internshipId: internship.internship_id,
                                })
                            "
                            target="_blank"
                            class="text-blue-500 hover:underline text-sm font-medium"
                        >
                            <i class="fas fa-file-alt mr-2"></i> View Resume
                        </a>
                        <a
                            v-if="internship.cover_letter"
                            :href="
                                route('company.download', {
                                    type: 'cover_letter',
                                    internshipId: internship.internship_id,
                                })
                            "
                            target="_blank"
                            class="text-blue-500 hover:underline text-sm font-medium"
                        >
                            <i class="fas fa-envelope-open-text mr-2"></i> View
                            Cover Letter
                        </a>
                    </div>
                </div>

                <!-- Status Update Dropdown -->
                <div class="flex justify-end">
                    <StatusUpdateDropdown
                        :application="{
                            id: internship.application_id,
                            status: internship.application_status,
                        }"
                        class="w-full"
                    />
                </div>

                <!-- Decorative Bottom Border -->
                <div
                    class="absolute bottom-0 left-0 w-full h-2 rounded-b-2xl bg-gradient-to-r from-[#00FFAB] to-[#00E6A0]"
                ></div>
            </div>
        </div>
    </div>
</template>
