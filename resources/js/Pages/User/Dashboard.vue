<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { useForm } from '@inertiajs/vue3';

const page = usePage();
const user = computed(() => page.props.user);  // This accesses the user data passed from the controller

// Internship application form
const applicationForm = useForm({
  internship_id: null,  // Set the internship ID when the user applies
  documents: {          // Store the uploaded documents (resume and cover letter)
    resume: null,
    cover_letter: null,
  },
});

// Props passed from the controller (internships)
const props = defineProps({
  internships: Array,  // List of internships available for the user
});

// Handle the file input change
const handleFileChange = (event) => {
  const file = event.target.files[0];
  // Ensure the file is correctly assigned to the appropriate field
  if (event.target.name === 'resume') {
    applicationForm.documents = applicationForm.documents || {};
    applicationForm.documents.resume = file;
  } else if (event.target.name === 'cover_letter') {
    applicationForm.documents = applicationForm.documents || {};
    applicationForm.documents.cover_letter = file;
  }
};

const apply = (internshipId) => {
  // Set internship_id when Apply button is clicked
  applicationForm.internship_id = internshipId;
  document.getElementById('applyModal').showModal();  // Show the modal for uploading documents
};

const submitApplication = () => {
  // Send the application form data to the backend via Inertia
  applicationForm.post(route('user.apply', applicationForm.internship_id), {
    onSuccess: () => {
      document.getElementById('applyModal').close();  // Close the modal on success
      alert('Your application is under review.');

      // Reset the form after submission
      applicationForm.reset();
      resetFileInputs();  // Reset the file input fields
    },
    onError: (errors) => {
      console.error(errors); // Handle validation errors
      alert('There was an issue with your application.');
    }
  });
};

const cancelApplication = () => {
  // Close the modal without submitting the form
  document.getElementById('applyModal').close();
};

// Reset file inputs after successful submission
const resetFileInputs = () => {
  const resumeInput = document.getElementById('resume');
  const coverLetterInput = document.getElementById('cover_letter');

  if (resumeInput) resumeInput.value = '';
  if (coverLetterInput) coverLetterInput.value = '';
};
</script>

<template>
  <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Available Internships</h2>

    <div v-if="props.internships.length > 0">
      <ul>
        <li v-for="internship in props.internships" :key="internship.id" class="mb-4 p-4 border border-gray-300 rounded-md shadow-sm">
          <h3 class="font-semibold text-xl">{{ internship.internship_name }}</h3>
          <p class="text-gray-600">{{ internship.city }}</p>
          <p class="text-sm text-gray-500">{{ internship.status }} | Salary: {{ internship.salary }}</p>
          <p class="mt-2">{{ internship.about }}</p>
          <p class="mt-2 font-semibold">Requirements:</p>
          <p>{{ internship.requirements }}</p>

          <!-- Apply Button -->
          <button 
            @click="apply(internship.id)"
            class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-indigo-700 focus:outline-none"
          >
            Apply
          </button>
        </li>
      </ul>
    </div>

    <div v-else>
      <p>No internships available at the moment.</p>
    </div>

    <!-- Modal for applying to an internship -->
    <dialog id="applyModal" class="p-6 rounded-lg shadow-lg">
      <h2 class="text-xl font-semibold text-gray-700 mb-4">Upload Documents</h2>
      <form @submit.prevent="submitApplication" enctype="multipart/form-data">
        <!-- Display User's Name and Email (Non-editable) -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Your Name</label>
          <p class="mt-1 text-gray-600">{{ user.name }}</p>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Your Email</label>
          <p class="mt-1 text-gray-600">{{ user.email }}</p>
        </div>

        <!-- File upload for resume -->
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

        <!-- File upload for cover letter -->
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

        <div class="mb-4 text-right">
          <!-- Submit Application Button -->
          <button
            type="submit"
            class="bg-indigo-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-indigo-700 focus:outline-none"
          >
            Submit Application
          </button>

          <!-- Cancel Button -->
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

<style scoped>
/* Optional custom styles for the form */
</style>
