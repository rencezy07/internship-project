<script setup>
import { ref, onMounted, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

// Props passed from the backend
const props = defineProps({
  internships: Array, // List of internships
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

// Reference for the modal
const applyModal = ref(null);

// Automatically select the first internship on page load
onMounted(() => {
  if (props.internships.length > 0) {
    console.log("Internships data:", props.internships);
    selectedInternship.value = props.internships[0];
    console.log("Default selected internship:", selectedInternship.value);
  } else {
    console.warn("No internships available to select.");
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

const apply = () => {
  const internshipId = selectedInternship.value?.internship_id; // Use the correct property name
  console.log("Selected internship in apply:", selectedInternship.value);
  console.log("Applying for internship with ID:", internshipId);

  if (!internshipId) {
    alert("No internship selected. Please select an internship first.");
    return;
  }

  applicationForm.internship_id = internshipId;
  applyModal.value.showModal(); // Open the modal
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
  applyModal.value.close(); // Use ref to close the modal
};
</script>

<template>
  <div class="flex max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <!-- Left Column: Internship List -->
    <div class="w-1/3 border-r pr-4">
      <h2 class="text-2xl font-semibold text-gray-700 mb-4">Available Internships</h2>
      <ul>
        <li
          v-for="internship in props.internships"
          :key="internship.id"
          @click="selectInternship(internship)"
          class="cursor-pointer p-4 mb-4 border border-gray-300 rounded-md shadow-sm hover:bg-gray-100"
        >
        <p class="text-sm text-gray-500">{{ internship.company_name }}</p>
        <img v-if="internship.image" :src="`/storage/${internship.image}`" alt="Internship Image">
          hahahaha
          <h3 class="font-semibold text-lg">{{ internship.internship_name }}</h3>
          <p class="text-sm text-gray-500">{{ internship.city }}</p>
          <p class="text-gray-600 mt-2">{{ internship.description }}</p>
        </li>
      </ul>
    </div>

    <!-- Right Column: Internship Details -->
    <div class="w-2/3 pl-4">
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
          <span class="font-semibold">Status:</span> {{ selectedInternship.status }}
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
         @click="apply"
  :disabled="!selectedInternship"
          class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-indigo-700 focus:outline-none"
        >
          Apply
        </button>
      </div>
      <div v-else class="text-gray-600 italic">Select an internship to view details.</div>
    </div>

    <!-- Modal for applying to an internship -->
    <dialog ref="applyModal" id="applyModal" class="p-6 rounded-lg shadow-lg">
      <h2 class="text-xl font-semibold text-gray-700 mb-4">Upload Documents</h2>
      <form @submit.prevent="submitApplication" enctype="multipart/form-data">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Your Name</label>
          <p class="mt-1 text-gray-600">{{ user.name }}</p>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Your Email</label>
          <p class="mt-1 text-gray-600">{{ user.email }}</p>
        </div>
        <div class="mb-4">
          <label for="resume" class="block text-sm font-medium text-gray-700">Upload your resume</label>
          <input
            type="file"
            id="resume"
            name="resume"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            @change="handleFileChange"
            required
          />
        </div>
        <div class="mb-4">
          <label for="cover_letter" class="block text-sm font-medium text-gray-700">Upload your cover letter</label>
          <input
            type="file"
            id="cover_letter"
            name="cover_letter"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            @change="handleFileChange"
            required
          />
        </div>
        <div class="flex justify-end">
          <button
            type="submit"
            class="bg-indigo-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-indigo-700 focus:outline-none"
          >
            Submit Application
          </button>
          <button
            type="button"
            @click="cancelApplication"
            class="ml-4 bg-gray-500 text-white px-6 py-2 rounded-md shadow-md hover:bg-gray-600 focus:outline-none"
          >
            Cancel
          </button>
        </div>
      </form>
    </dialog>
  </div>
</template>
