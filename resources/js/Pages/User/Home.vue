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

  applicationForm.post(route("user.apply", { internshipId: applicationForm.internship_id }), {
    onSuccess: () => {
      applyModal.value.close(); // Use Vue ref to close the modal
      alert("Your application is under review.");
      applicationForm.reset();
    },
    onError: (errors) => {
      console.error(errors); // Handle validation errors
      alert("There was an issue with your application.");
    },
  });
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
    <!-- Left Column: Internship List -->
    <div class="w-1/3 border-r pr-4 left-column">
      <h2 class="text-2xl font-semibold text-gray-700 mb-4">Available Internships</h2>
      <ul>
        <li
          v-for="internship in props.internships"
          :key="internship.id"
          @click="selectInternship(internship)"
          class="cursor-pointer p-4 mb-4 border border-gray-300 rounded-md shadow-sm hover:bg-gray-100"
        >
        <img v-if="internship.image" :src="`/storage/${internship.image}`" alt="Internship Image">

          <h3 class="font-semibold text-lg">{{ internship.internship_name }}</h3>
          <p class="text-sm text-gray-500">{{ internship.company_name }}</p>
          <p class="text-sm text-gray-500">{{ internship.city }}</p>
          <p class="text-gray-600 mt-2">{{ internship.description }}</p>
        </li>
      </ul>
    </div>

    <!-- Right Column: Internship Details -->
    <div class="w-2/3 pl-4 right-column">
      <div v-if="selectedInternship" class="p-4 bg-gray-50 rounded-md shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800">
          {{ selectedInternship.internship_name }}
        </h2>
        <p class="text-lg text-gray-600 mt-2">{{ selectedInternship.company_name }}</p>
        <p class="text-gray-700 mt-4">{{ selectedInternship.about }}</p>
        <p class="text-gray-500 mt-2">
          <span class="font-semibold">City:</span> {{ selectedInternship.city }}
        </p>
        <p class="text-gray-500">
          <span class="font-semibold">Employment Type:</span> {{ selectedInternship.employment_type }}
        </p>
        <p class="text-gray-500">
  <span class="font-semibold">Application Deadline:</span>
  {{(selectedInternship.application_deadline)  }} 
</p>

              <p class="text-gray-500">
        <span class="font-semibold">Status: &nbsp;</span>
        <span :class="selectedInternship.is_open ? 'text-green-500' : 'text-red-500'">
          {{ selectedInternship.is_open ? 'Active' : 'Inactive' }}
        </span>
      </p>

        <p class="text-gray-500">
          <span class="font-semibold">Salary:</span> {{ selectedInternship.salary }}
        </p>
        <p class="mt-4">
          <span class="font-semibold">Requirements:</span>
          <span>{{ selectedInternship.requirements }}</span>
        </p>

        <!-- Apply Button -->
        <button
          @click="apply(selectedInternship.internship_id)"
          :disabled="!selectedInternship"
          class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-indigo-700 focus:outline-none"
        >
          Apply
        </button>
      </div>
      <div v-else class="text-gray-600 italic">Select an internship to view details.</div>
    </div>

    <!-- Modal for applying to an internship -->
    <dialog
  ref="applyModal"
  id="applyModal"
  class="p-6 rounded-lg shadow-lg max-w-lg w-full"
  aria-labelledby="upload-documents-title"
  aria-describedby="upload-documents-description"
>
  <h2 id="upload-documents-title" class="text-xl font-semibold text-gray-700 mb-4">
    Upload Documents
  </h2>
  <p id="upload-documents-description" class="sr-only">
    Provide your resume and cover letter to apply for this internship.
  </p>

  <form @submit.prevent="submitApplication" enctype="multipart/form-data">
    <!-- User Name -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700">Your Name</label>
      <p class="mt-1 text-gray-600">{{ user.first_name }}</p>
    </div>

    <!-- User Email -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700">Your Email</label>
      <p class="mt-1 text-gray-600">{{ user.email }}</p>
    </div>

    <!-- Resume Upload -->
    <div class="mb-4">
      <label for="resume" class="block text-sm font-medium text-gray-700">Upload your resume</label>
      <input
        type="file"
        id="resume"
        name="resume"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        @change="handleFileChange"
        accept=".pdf,.doc,.docx"  
        
        required
      />
      <!-- File Preview -->
      <p v-if="applicationForm.documents.resume" class="text-sm text-gray-500 mt-2">
        Selected File: {{ applicationForm.documents.resume.name }}
      </p>
      <!-- Error Message -->
      <div v-if="applicationForm.errors.resume" class="text-red-500 text-sm mt-1">
        {{ applicationForm.errors.resume }}
      </div>
    </div>

    <!-- Cover Letter Upload -->
    <div class="mb-4">
      <label for="cover_letter" class="block text-sm font-medium text-gray-700">
        Upload your cover letter
      </label>
      <input
        type="file"
        id="cover_letter"
        name="cover_letter"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        @change="handleFileChange"
        accept=".pdf,.doc,.docx"  
        required
      />
      <!-- File Preview -->
      <p v-if="applicationForm.documents.cover_letter" class="text-sm text-gray-500 mt-2">
        Selected File: {{ applicationForm.documents.cover_letter.name }}
      </p>
      <!-- Error Message -->
      <div v-if="applicationForm.errors.cover_letter" class="text-red-500 text-sm mt-1">
        {{ applicationForm.errors.cover_letter }}
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-4">
      <button
        type="submit"
        :disabled="applicationForm.processing"
        class="bg-indigo-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-indigo-700 focus:outline-none"
      >
        <span v-if="applicationForm.processing">Submitting...</span>
        <span v-else>Submit Application</span>
      </button>
      <button
        type="button"
        @click="cancelApplication"
        class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md shadow-md hover:bg-gray-400 focus:outline-none"
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
  top: 100px;  /* Adjust this value to match the height of your navbar */
  background-color: white;
  z-index: 10; /* Ensure the sticky column is above other content */
  padding-left: 20px;
  padding-right: 20px;
  height: calc(100vh - 200px); /* Adjust for top offset */
}
</style>
