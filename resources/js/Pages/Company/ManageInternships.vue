<script setup>
import { ref } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";

// Reactive state for editing mode
const editingInternship = ref(null);

// Retrieve internships from props passed via Inertia
const { internships } = usePage().props;

// Initialize the form using useForm
const form = useForm({
    internship_id: null,
    internship_name: "",
    city: "",
    salary: "",
    is_open: true,
});

// Function to set the internship in edit mode
const editInternship = (internship) => {
    editingInternship.value = internship; // Set editing mode
    form.internship_id = internship.internship_id; // Populate form with existing data
    form.internship_name = internship.internship_name;
    form.city = internship.city;
    form.salary = internship.salary;
    form.is_open = internship.is_open;
};

// Function to save the internship
const saveInternship = () => {
    form.put(route("company.update", { internshipId: form.internship_id }), {
        onSuccess: () => {
            // Find the index of the updated internship in the array
            const index = internships.findIndex(
                (internship) => internship.internship_id === form.internship_id
            );

            // Update the internship in the local array
            if (index !== -1) {
                internships[index] = { ...internships[index], ...form };
            }

            editingInternship.value = null; // Exit editing mode
            form.reset(); // Clear the form
            alert("Internship updated successfully!");
        },
        onError: () => {
            alert("Failed to update internship. Please check your input.");
        },
    });
};

// Function to cancel editing
const cancelEditing = () => {
    editingInternship.value = null; // Exit editing mode
    form.reset(); // Reset the form fields
};

// Function to delete an internship
const deleteInternship = (internshipId) => {
    if (confirm("Are you sure you want to delete this internship?")) {
        form.delete(route("company.delete", { internshipId }), {
            onSuccess: () => {
                // Remove the deleted internship from the local array
                const index = internships.findIndex(
                    (internship) => internship.internship_id === internshipId
                );
                if (index !== -1) {
                    internships.splice(index, 1);
                }

                alert("Internship deleted successfully!");
            },
            onError: () => {
                alert("Failed to delete internship. Please try again.");
            },
        });
    }
};
</script>

<template>
    <div class="ml-60 max-w-7xl mx-auto p-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-extrabold text-[#00FFAB] tracking-wide">
                Manage Internships
            </h1>
            <i class="fas fa-briefcase text-4xl text-[#00FFAB]"></i>
        </div>

        <!-- Internship Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <!-- Table Header -->
                <thead class="bg-[#00FFAB] text-white">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-sm font-bold uppercase tracking-wider"
                        >
                            Internship Name
                        </th>
                        <th
                            class="px-6 py-3 text-left text-sm font-bold uppercase tracking-wider"
                        >
                            City
                        </th>
                        <th
                            class="px-6 py-3 text-left text-sm font-bold uppercase tracking-wider"
                        >
                            Salary
                        </th>
                        <th
                            class="px-6 py-3 text-left text-sm font-bold uppercase tracking-wider"
                        >
                            Status
                        </th>
                        <th
                            class="px-6 py-3 text-center text-sm font-bold uppercase tracking-wider"
                        >
                            Actions
                        </th>
                    </tr>
                </thead>
                <!-- Table Body -->
                <tbody class="divide-y divide-gray-200">
                    <tr
                        v-for="internship in internships"
                        :key="internship.internship_id"
                        class="hover:bg-gray-50 transition duration-300"
                    >
                        <!-- Internship Name -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-gray-800 font-semibold">{{
                                internship.internship_name
                            }}</span>
                        </td>
                        <!-- City -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-gray-600">{{
                                internship.city
                            }}</span>
                        </td>
                        <!-- Salary -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-gray-600"
                                >₱ {{ internship.salary }}</span
                            >
                        </td>
                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-block px-3 py-1 text-sm font-medium text-white rounded-full"
                                :class="
                                    internship.is_open
                                        ? 'bg-green-500'
                                        : 'bg-red-500'
                                "
                            >
                                {{ internship.is_open ? "Open" : "Closed" }}
                            </span>
                        </td>
                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <button
                                @click="editInternship(internship)"
                                class="text-blue-500 hover:text-blue-700 transition-all duration-300 mr-3"
                            >
                                <i class="fas fa-edit text-lg"></i>
                            </button>
                            <button
                                @click="
                                    deleteInternship(internship.internship_id)
                                "
                                class="text-red-500 hover:text-red-700 transition-all duration-300"
                            >
                                <i class="fas fa-trash text-lg"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Edit Internship Form -->
        <div
            v-if="editingInternship"
            class="mt-10 bg-gray-50 rounded-2xl p-8 shadow-lg"
        >
            <h2 class="text-2xl font-extrabold text-gray-700 mb-6">
                Edit Internship
            </h2>
            <form
                @submit.prevent="saveInternship"
                class="grid grid-cols-1 md:grid-cols-2 gap-6"
            >
                <!-- Internship Name -->
                <div>
                    <label
                        for="internship_name"
                        class="block text-sm font-bold text-gray-600"
                        >Internship Name</label
                    >
                    <input
                        v-model="form.internship_name"
                        type="text"
                        id="internship_name"
                        class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#00FFAB] text-gray-700"
                        placeholder="Enter Internship Name"
                        required
                    />
                </div>

                <!-- City -->
                <div>
                    <label
                        for="city"
                        class="block text-sm font-bold text-gray-600"
                        >City</label
                    >
                    <input
                        v-model="form.city"
                        type="text"
                        id="city"
                        class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#00FFAB] text-gray-700"
                        placeholder="Enter City"
                        required
                    />
                </div>

                <!-- Salary -->
                <div>
                    <label
                        for="salary"
                        class="block text-sm font-bold text-gray-600"
                        >Salary</label
                    >
                    <input
                        v-model="form.salary"
                        type="number"
                        id="salary"
                        class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#00FFAB] text-gray-700"
                        placeholder="Enter Salary"
                        required
                    />
                </div>

                <!-- Open Status -->
                <div class="flex items-center mt-6">
                    <label
                        for="is_open"
                        class="text-sm font-bold text-gray-600 mr-3"
                        >Open Status:</label
                    >
                    <input
                        v-model="form.is_open"
                        type="checkbox"
                        id="is_open"
                        class="w-5 h-5 text-[#00FFAB] focus:ring-[#00FFAB] border-gray-300 rounded"
                    />
                </div>

                <!-- Buttons -->
                <div class="col-span-2 flex justify-end space-x-4">
                    <button
                        type="button"
                        @click="cancelEditing"
                        class="px-6 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition-all"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-6 py-2 bg-[#00FFAB] text-white rounded-md hover:bg-[#00E6A0] transition-all"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
