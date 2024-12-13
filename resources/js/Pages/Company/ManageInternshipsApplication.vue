<script setup>
import { usePage } from '@inertiajs/vue3';
import StatusUpdateDropdown from '@/Components/StatusUpdateDropdown.vue'; // Import the dropdown component

// Get the internships and their applications from Inertia props
const { internships } = usePage().props;
console.log(internships); // Log to check the structure of internships and their applications

const reloadInternships = () => {
  Inertia.reload({
    only: ['internships'],
    onSuccess: () => console.log('Internships reloaded'),
  });
};



// Use this function in your `StatusUpdateDropdown` success callback if needed.


</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Manage Internship Applications</h1>

    <div class="grid grid-cols-1 gap-4">
      <div
        v-for="internship in internships"
        :key="internship.internship_id"
        class="flex items-center justify-between p-4 bg-gray-100 rounded-lg shadow-md"
      >
        <!-- Internship Details -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4">
          <div>
            <h3 class="text-lg font-semibold text-gray-800">
              {{ internship.internship_name }}
            </h3>
            <p class="text-sm text-gray-600">
              Internship ID: {{ internship.internship_id }}
            </p>
            <p class="text-sm text-gray-600">
              Application ID: {{ internship.application_id }}
            </p>
          </div>
         
        </div>

        <!-- Applicant and Dropdown -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4">
          <div>
            <h4 class="text-sm font-semibold text-gray-800">
              Applicant: {{ internship.first_name }}
            </h4>
            <img style="width: 30px; height: 30px;" :src="`/storage/${internship.profile_picture}`" alt="Internship Image">
          </div>



          <p v-if="internship.resume" class="text-sm text-blue-600">
  <a
    :href="route('company.download', { type: 'resume', internshipId: internship.internship_id })"
    target="_blank"
    class="hover:underline"
  >
    View Resume
  </a>
  <a
    :href="route('company.download', { type: 'cover_letter', internshipId: internship.internship_id })"
    target="_blank"
    class="hover:underline"
  >
    View Cover Letter
  </a>
</p>

         
          
          <div class="mt-2 sm:mt-0">
            <StatusUpdateDropdown :application="{ id: internship.application_id, status: internship.application_status }" /> </div>
          </div>
        </div>
      </div>
    </div>
</template>
