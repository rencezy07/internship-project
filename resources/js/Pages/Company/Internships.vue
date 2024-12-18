<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue"; // Make sure to import ref

// Form for adding a new internship
const internshipForm = useForm({
    internship_name: "",
    city: "",
    employment_type: "full-time", // Default to 'full-time'
    salary: "",
    about: "",
    requirements: "",
    image: "null",
    is_open: true, //new
    duration: "", // New field for internship duration
    start_date: "", // New field for start date
    end_date: "", // New field for end date
    benefits: "", // New field for benefits
    application_deadline: "", // New field for application deadline
    tags: "", // New field for tags
});

// Fetch internships data passed from the controller
const props = defineProps({
    internships: Array, // Internships passed from the controller
});

// Form submission
const submitForm = () => {
    internshipForm.post(route("company.internship.store"), {
        onSuccess: () => {
            internshipForm.reset();
        },
    });
};

// Selected internship for modal
const selectedInternship = ref(null);

// Open the modal
const openModal = (internship) => {
    selectedInternship.value = internship;
};

// Close the modal
const closeModal = () => {
    selectedInternship.value = null;
};
</script>

<template>
    <div class="ml-80 max-w-2xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-[#00FFAB]">Add Internship</h2>
            <i class="fas fa-briefcase text-3xl text-[#00FFAB]"></i>
        </div>
        <!-- Internship Form -->
        <form
            @submit.prevent="submitForm"
            class="grid grid-cols-1 md:grid-cols-2 gap-4"
        >
            <!-- Upload Image -->
            <div class="col-span-2">
                <label
                    for="image"
                    class="block text-sm font-medium text-gray-700"
                    >Upload Image</label
                >
                <input
                    @change="
                        (event) =>
                            (internshipForm.image = event.target.files[0])
                    "
                    type="file"
                    id="image"
                    class="w-full mt-1 px-3 py-2 border rounded-lg shadow focus:ring-2 focus:ring-[#00FFAB] focus:border-[#00FFAB]"
                    accept="image/*"
                    required
                />
            </div>

            <!-- Internship Name -->
            <div>
                <label
                    for="internship_name"
                    class="block text-sm font-medium text-gray-700"
                    >Internship Name</label
                >
                <input
                    v-model="internshipForm.internship_name"
                    type="text"
                    id="internship_name"
                    class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#00FFAB] text-sm"
                    placeholder="Enter Internship Name"
                    required
                />
            </div>

            <!-- City -->
            <div>
                <label
                    for="city"
                    class="block text-sm font-medium text-gray-700"
                    >City</label
                >
                <input
                    v-model="internshipForm.city"
                    type="text"
                    id="city"
                    class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#00FFAB] text-sm"
                    placeholder="Enter City"
                    required
                />
            </div>

            <!-- Employment Type -->
            <div>
                <label
                    for="employment_type"
                    class="block text-sm font-medium text-gray-700"
                    >Employment Type</label
                >
                <select
                    v-model="internshipForm.employment_type"
                    id="employment_type"
                    class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#00FFAB] text-sm"
                >
                    <option value="full-time">Full-Time</option>
                    <option value="part-time">Part-Time</option>
                </select>
            </div>

            <!-- Is Open -->
            <div>
                <label
                    for="is_open"
                    class="block text-sm font-medium text-gray-700"
                    >Is Open?</label
                >
                <select
                    v-model="internshipForm.is_open"
                    id="is_open"
                    class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#00FFAB] text-sm"
                >
                    <option :value="true">Yes</option>
                    <option :value="false">No</option>
                </select>
            </div>

            <!-- Salary -->
            <div>
                <label
                    for="salary"
                    class="block text-sm font-medium text-gray-700"
                    >Salary</label
                >
                <input
                    v-model="internshipForm.salary"
                    type="number"
                    id="salary"
                    class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#00FFAB] text-sm"
                    placeholder="Enter Salary"
                    required
                />
            </div>

            <!-- Duration -->
            <div>
                <label
                    for="duration"
                    class="block text-sm font-medium text-gray-700"
                    >Duration</label
                >
                <input
                    v-model="internshipForm.duration"
                    type="text"
                    id="duration"
                    class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#00FFAB] text-sm"
                    placeholder="e.g., 3 months"
                    required
                />
            </div>

            <!-- Start Date -->
            <div>
                <label
                    for="start_date"
                    class="block text-sm font-medium text-gray-700"
                    >Start Date</label
                >
                <input
                    v-model="internshipForm.start_date"
                    type="date"
                    id="start_date"
                    class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#00FFAB] text-sm"
                    required
                />
            </div>

            <!-- End Date -->
            <div>
                <label
                    for="end_date"
                    class="block text-sm font-medium text-gray-700"
                    >End Date</label
                >
                <input
                    v-model="internshipForm.end_date"
                    type="date"
                    id="end_date"
                    class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#00FFAB] text-sm"
                    required
                />
            </div>

            <!-- About -->
            <div class="col-span-2">
                <label
                    for="about"
                    class="block text-sm font-medium text-gray-700"
                    >About</label
                >
                <textarea
                    v-model="internshipForm.about"
                    id="about"
                    rows="2"
                    class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#00FFAB] text-sm"
                    placeholder="Short description"
                    required
                ></textarea>
            </div>

            <!-- Requirements -->
            <div class="col-span-2">
                <label
                    for="requirements"
                    class="block text-sm font-medium text-gray-700"
                    >Requirements</label
                >
                <textarea
                    v-model="internshipForm.requirements"
                    id="requirements"
                    rows="2"
                    class="w-full mt-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#00FFAB] text-sm"
                    placeholder="List the requirements"
                    required
                ></textarea>
            </div>

            <!-- Application Deadline -->
            <div>
                <label
                    for="application_deadline"
                    class="block text-sm font-medium text-gray-700"
                    >Application Deadline</label
                >
                <input
                    v-model="internshipForm.application_deadline"
                    type="date"
                    id="application_deadline"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#00FFAB] focus:border-[#00FFAB] text-sm"
                    required
                />
            </div>

            <!-- Tags -->
            <div>
                <label
                    for="tags"
                    class="block text-sm font-medium text-gray-700"
                    >Tags (optional)</label
                >
                <input
                    v-model="internshipForm.tags"
                    type="text"
                    id="tags"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#00FFAB] focus:border-[#00FFAB] text-sm"
                    placeholder="e.g., marketing, remote, tech"
                />
            </div>

            <!-- Benefits -->
            <div class="md:col-span-2">
                <label
                    for="benefits"
                    class="block text-sm font-medium text-gray-700"
                    >Benefits (optional)</label
                >
                <textarea
                    v-model="internshipForm.benefits"
                    id="benefits"
                    rows="3"
                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-[#00FFAB] focus:border-[#00FFAB] text-sm"
                    placeholder="Describe the benefits or perks"
                ></textarea>
            </div>

            <!-- Submit Button -->
            <div class="col-span-2 flex justify-center mt-2">
                <button
                    type="submit"
                    class="bg-[#00FFAB] text-white px-6 py-2 rounded-md shadow-md hover:bg-[#00E6A0] transition duration-300"
                >
                    Submit
                </button>
            </div>
        </form>

        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <h2 class="text-3xl font-bold text-[#00FFAB] mt-10 mb-6">
                Existing Internships
            </h2>

            <!-- Internship List -->
            <div
                v-if="props.internships.length > 0"
                class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-2 gap-6"
            >
                <div
                    v-for="internship in props.internships"
                    :key="internship.id"
                    class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow border border-gray-200"
                >
                    <!-- Internship Image -->
                    <img
                        v-if="internship.image"
                        :src="`/storage/${internship.image}`"
                        alt="Internship Image"
                        class="h-40 w-full object-cover rounded-md mb-1"
                    />

                    <!-- Internship Details -->
                    <h3 class="text-lg font-bold text-gray-800 mb-2">
                        {{ internship.internship_name }}
                    </h3>
                    <p class="text-sm text-gray-600 mb-1">
                        <i class="fas fa-map-marker-alt text-[#00FFAB] mr-1"></i
                        >{{ internship.city }}
                    </p>
                    <p class="text-sm text-gray-600 mb-1">
                        <i class="fas fa-dollar-sign text-[#00FFAB] mr-1"></i
                        >Salary: {{ internship.salary }}
                    </p>
                    <p class="text-sm text-gray-500 mb-4">
                        <i class="fas fa-check-circle text-[#00FFAB] mr-1"></i
                        >Status: {{ internship.status }}
                    </p>

                    <!-- About -->
                    <p class="text-sm text-gray-700 mb-4 line-clamp-3">
                        {{ internship.about }}
                    </p>

                    <!-- Hover CTA -->
                    <div class="mt-4">
                        <button
                            @click="openModal(internship)"
                            class="bg-[#00FFAB] text-white w-full py-2 rounded-lg shadow-md hover:bg-[#00E6A0] transition-all"
                        >
                            View Details
                        </button>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else>
                <p class="text-gray-600 text-center text-lg">
                    No internships found.
                </p>
            </div>

            <!-- Modal -->
            <transition name="fade">
                <div
                    v-if="selectedInternship"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                >
                    <div
                        class="bg-white w-11/12 max-w-2xl rounded-lg p-6 shadow-lg"
                    >
                        <!-- Modal Header -->
                        <div
                            class="flex justify-between items-center border-b pb-4"
                        >
                            <h3 class="text-2xl font-bold text-gray-800">
                                {{ selectedInternship.internship_name }}
                            </h3>
                            <button
                                @click="closeModal"
                                class="text-gray-600 hover:text-gray-900"
                            >
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">
                                <i
                                    class="fas fa-map-marker-alt text-[#00FFAB] mr-1"
                                ></i
                                >{{ selectedInternship.city }}
                            </p>
                            <p class="text-sm text-gray-600 mb-2">
                                <i
                                    class="fas fa-dollar-sign text-[#00FFAB] mr-1"
                                ></i
                                >Salary: {{ selectedInternship.salary }}
                            </p>
                            <p class="text-sm text-gray-500 mb-4">
                                <i
                                    class="fas fa-check-circle text-[#00FFAB] mr-1"
                                ></i
                                >Status: {{ selectedInternship.status }}
                            </p>
                            <p class="text-sm text-gray-700 mb-4">
                                {{ selectedInternship.about }}
                            </p>
                            <p class="text-sm text-gray-700 font-semibold">
                                Requirements:
                            </p>
                            <ul class="list-disc pl-5 text-sm text-gray-600">
                                <li
                                    v-for="requirement in selectedInternship.requirements.split(
                                        ','
                                    )"
                                    :key="requirement"
                                >
                                    {{ requirement }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<style scoped>
/* Optional custom styles for the form */
/* Simple fade transition for the modal */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
