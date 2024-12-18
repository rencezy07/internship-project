<script setup>
import { ref, onMounted, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

// Props passed from the backend
const props = defineProps({
    internships: Array,
});

// Access page props using usePage()
const page = usePage();
const user = computed(() => page.props.user); // Access user data

// State for the selected internship
const selectedInternship = ref(null);

// Internship application form
const applicationForm = useForm({
    internship_id: null,
    documents: {
        resume: null,
        cover_letter: null,
    },
});

const applyModal = ref(null);

onMounted(() => {
    if (props.internships.length > 0) {
        selectedInternship.value = props.internships[0];
    } else {
    }
});

// Handle selecting an internship
const selectInternship = (internship) => {
    selectedInternship.value = internship;
    console.log("Selected internship:", selectedInternship.value);
};

// Handle file input changes
const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (event.target.name === "resume") {
        applicationForm.documents.resume = file;
    } else if (event.target.name === "cover_letter") {
        applicationForm.documents.cover_letter = file;
    }
};

// Open the modal and set the internship ID
const apply = (internshipId) => {
    if (!internshipId) {
        console.error("No internship ID provided.");
        return;
    }
    console.log("Setting internship ID:", internshipId);
    applicationForm.internship_id = internshipId;
    applyModal.value.showModal(); // Use ref to show the modal
};

const submitApplication = () => {
    if (!applicationForm.internship_id) {
        alert("No internship selected for application.");
        return;
    }

    applicationForm.post(
        route("user.apply", { internshipId: applicationForm.internship_id }),
        {
            onSuccess: () => {
                applyModal.value.close(); // Use Vue ref to close the modal
                alert("Your application is under review.");
                applicationForm.reset();
            },
            onError: (errors) => {
                console.error(errors); // Handle validation errors
                alert("There was an issue with your application.");
            },
        }
    );
};

// Cancel application modal
const cancelApplication = () => {
    if (confirm("Are you sure you want to cancel this application?")) {
        applyModal.value.close();
    }
    applyModal.value.close(); // Use ref to close the modal
};
</script>



<template>
    <div class="flex max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Left Column: Internship List -->
            <div
                class="w-full md:w-1/2 bg-gray-700 backdrop-blur-lg rounded-2xl shadow-2xl border border-gray-100 p-6 hover:shadow-2xl transition-all"
            >
                <h2
                    class="text-3xl font-extrabold text-[#00FFAB] mb-4 border-b-4 border-[#00FFAB] pb-2 uppercase tracking-wider"
                >
                    Available Internships
                </h2>
                <ul class="space-y-4">
                    <li
                        v-for="internship in props.internships"
                        :key="internship.id"
                        @click="selectInternship(internship)"
                        class="relative bg-white/90 rounded-xl shadow-lg hover:shadow-2xl transition-transform transform hover:scale-[1.03] cursor-pointer p-5 border border-gray-200 overflow-hidden"
                    >
                        <!-- Ribbon for Status -->
                        <span
                            class="absolute top-0 left-0 bg-gradient-to-r from-[#00FFAB] to-[#00E6A0] text-black text-xs font-semibold px-3 py-1 rounded-br-xl shadow-md"
                        >
                            {{ internship.is_open ? "Open" : "Closed" }}
                        </span>

                        <!-- Internship Details -->
                        <div class="flex items-center gap-4">
                            <!-- Internship Image -->
                            <div
                                class="w-16 h-16 rounded-xl overflow-hidden shadow-md"
                            >
                                <img
                                    v-if="internship.image"
                                    :src="`/storage/${internship.image}`"
                                    alt="Internship Image"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <div class="flex-1">
                                <h3
                                    class="font-semibold text-xl text-gray-800 mb-1"
                                >
                                    {{ internship.internship_name }}
                                </h3>
                                <p
                                    class="text-sm text-gray-500 flex items-center gap-1"
                                >
                                    <i
                                        class="fas fa-building text-[#00FFAB]"
                                    ></i>
                                    {{ internship.company_name }}
                                </p>
                                <p
                                    class="text-sm text-gray-500 flex items-center gap-1"
                                >
                                    <i
                                        class="fas fa-map-marker-alt text-[#00FFAB]"
                                    ></i>
                                    {{ internship.city }}
                                </p>
                            </div>
                        </div>

                        <!-- Description Preview -->
                        <p class="mt-3 text-gray-500 text-sm line-clamp-2">
                            {{ internship.description }}
                        </p>

                        <!-- Hover Action -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-[#00FFAB]/20 via-transparent to-transparent flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity"
                        >
                            <p class="text-[#00FFAB] font-bold text-lg">
                                View Details
                            </p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Right Column: Internship Details -->
            <div class="w-full md:w-1/2 sticky top-24 h-fit">
                <div
                    v-if="selectedInternship"
                    class="p-8 bg-white/90 backdrop-blur-xl rounded-2xl shadow-xl border border-gray-200 hover:scale-[1.02] transform transition-transform"
                >
                    <!-- Internship Title -->
                    <h2
                        class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight tracking-tight"
                    >
                        {{ selectedInternship.internship_name }}
                    </h2>
                    <p
                        class="text-lg text-gray-600 flex items-center gap-2 mb-6"
                    >
                        <i class="fas fa-building text-[#00FFAB]"></i>
                        {{ selectedInternship.company_name }}
                    </p>

                    <!-- Description -->
                    <p class="text-gray-700 text-lg leading-relaxed mb-6">
                        {{ selectedInternship.about }}
                    </p>

                    <!-- Details Grid -->
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-600"
                    >
                        <div class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-[#00FFAB]"></i>
                            <p>
                                <strong>City:</strong>
                                {{ selectedInternship.city }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-briefcase text-[#00FFAB]"></i>
                            <p>
                                <strong>Type:</strong>
                                {{ selectedInternship.employment_type }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-[#00FFAB]"></i>
                            <p>
                                <strong>Deadline:</strong>
                                {{ selectedInternship.application_deadline }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-[#00FFAB]"></i>
                            <p>
                                <strong>Status:</strong>
                                <span
                                    :class="
                                        selectedInternship.is_open
                                            ? 'text-green-500'
                                            : 'text-red-500'
                                    "
                                >
                                    {{
                                        selectedInternship.is_open
                                            ? "Active"
                                            : "Inactive"
                                    }}
                                </span>
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-dollar-sign text-[#00FFAB]"></i>
                            <p>
                                <strong>Salary:</strong>
                                {{ selectedInternship.salary }}
                            </p>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fas fa-tasks text-[#00FFAB]"></i>
                            <p>
                                <strong>Requirements:</strong>
                                {{ selectedInternship.requirements }}
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-center mt-8 flex gap-4">
                        <button
                            @click="apply(selectedInternship.internship_id)"
                            :disabled="!selectedInternship"
                            class="px-6 py-2 bg-[#00FFAB] text-black font-bold rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-transform disabled:bg-gray-300"
                        >
                            Apply Now
                        </button>
                    </div>
                </div>

                <!-- No Internship Selected -->
                <div
                    v-else
                    class="flex flex-col items-center justify-center text-center text-gray-500 py-24 bg-white/80 backdrop-blur-md rounded-2xl shadow-xl"
                >
                    <i
                        class="fas fa-info-circle text-6xl text-gray-300 mb-4"
                    ></i>
                    <p class="text-lg font-semibold">
                        Select an internship to view details.
                    </p>
                </div>
            </div>
        </div>

<!-- Modal for applying to an internship -->
<dialog
    ref="applyModal"
    id="applyModal"
    v-if="selectedInternship"
    class="p-6 rounded-lg shadow-2xl max-w-xl w-full bg-white"
    aria-labelledby="upload-documents-title"
    aria-describedby="upload-documents-description"
  >
    <!-- Internship Name at the Top -->
    <div class="mb-6">
      <h1
        id="upload-documents-title"
        class="text-2xl font-bold text-gray-800 text-center"
      >
        Apply for <span class="text-[#00FFAB] font-extrabold">{{  selectedInternship.internship_name }}</span> 
      </h1>
      <p
        id="upload-documents-description"
        class="text-sm text-gray-500 text-center mt-1"
      >
        Provide your resume and cover letter to submit your application.
      </p>
    </div>

    <!-- Application Form -->
    <form @submit.prevent="submitApplication" enctype="multipart/form-data">
      <!-- User Details -->
      <div class="grid grid-cols-2 gap-6 mb-6">
        <!-- User Name -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Your Name</label>
          <p class="mt-1 text-gray-800 font-semibold">{{ user.first_name }}</p>
        </div>
        <!-- User Email -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Your Email</label>
          <p class="mt-1 text-gray-800 font-semibold">{{ user.email }}</p>
        </div>
      </div>

      <!-- Resume Upload -->
      <div class="mb-6">
        <label for="resume" class="block text-sm font-medium text-gray-700">
          Upload your resume
        </label>
        <input
          type="file"
          id="resume"
          name="resume"
          class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00FFAB] focus:border-[#00FFAB] transition duration-300"
          @change="handleFileChange"
          accept=".pdf,.doc,.docx"
          required
        />
        <!-- File Preview -->
        <p
          v-if="applicationForm.documents.resume"
          class="text-sm text-gray-500 mt-2 italic"
        >
          Selected File: {{ applicationForm.documents.resume.name }}
        </p>
        <!-- Error Message -->
        <p
          v-if="applicationForm.errors.resume"
          class="text-sm text-red-500 mt-1"
        >
          {{ applicationForm.errors.resume }}
        </p>
      </div>

      <!-- Cover Letter Upload -->
      <div class="mb-6">
        <label
          for="cover_letter"
          class="block text-sm font-medium text-gray-700"
        >
          Upload your cover letter
        </label>
        <input
          type="file"
          id="cover_letter"
          name="cover_letter"
          class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00FFAB] focus:border-[#00FFAB] transition duration-300"
          @change="handleFileChange"
          accept=".pdf,.doc,.docx"
          required
        />
        <!-- File Preview -->
        <p
          v-if="applicationForm.documents.cover_letter"
          class="text-sm text-gray-500 mt-2 italic"
        >
          Selected File: {{ applicationForm.documents.cover_letter.name }}
        </p>
        <!-- Error Message -->
        <p
          v-if="applicationForm.errors.cover_letter"
          class="text-sm text-red-500 mt-1"
        >
          {{ applicationForm.errors.cover_letter }}
        </p>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end space-x-4 mt-8">
        <button
          type="submit"
          :disabled="applicationForm.processing"
          class="bg-[#00FFAB] text-black font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-[#00D699] focus:outline-none focus:ring-2 focus:ring-[#00FFAB] transition duration-300"
        >
          <span v-if="applicationForm.processing">Submitting...</span>
          <span v-else>Submit Application</span>
        </button>
        <button
          type="button"
          @click="cancelApplication"
          class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg shadow-md hover:bg-gray-400 focus:outline-none transition duration-300"
        >
          Cancel
        </button>
      </div>
    </form>
  </dialog>

    </div>
</template>

<style scoped>
img {
    height: 60px;
    width: 60px;
}
.right-column {
    position: sticky;
    top: 100px; /* Adjust this value to match the height of your navbar */
    background-color: white;
    z-index: 10; /* Ensure the sticky column is above other content */
    padding-left: 20px;
    padding-right: 20px;
    height: calc(100vh - 200px); /* Adjust for top offset */
}

/* Smooth hover effects */
li {
    transition: transform 0.3s ease, box-shadow 0.3s ease, opacity 0.3s ease;
}

/* Truncate long descriptions */
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
