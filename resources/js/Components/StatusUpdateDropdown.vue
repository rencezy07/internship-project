<template>
  <div class="flex items-center gap-2">
    <!-- Status Update Dropdown -->
    <form class="relative">
      <label for="status" class="sr-only">Application Status:</label>
      <select
        v-model="form.status"
        name="status"
        id="status"
        class="w-48 text-sm font-semibold text-gray-800 bg-white border border-gray-300 rounded-lg shadow-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#00FFAB] focus:border-[#00FFAB] transition duration-300 appearance-none cursor-pointer hover:shadow-md"
        @change="submit"
      >
        <option value="under review" class="text-gray-700">Under Review</option>
        <option value="accepted" class="text-green-600">Accepted</option>
        <option value="rejected" class="text-red-600">Rejected</option>
      </select>

      <!-- Down Arrow Icon -->
      <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-4 h-4 text-gray-500"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
          />
        </svg>
      </div>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

// Props
const props = defineProps({
  application: Object, // Expect an application object with `id` and `status`
});

// Form and logic
const form = useForm({
  status: props.application.status, // Bind application status
});

let previousStatus = props.application.status; // Store the initial status

const submit = () => {
  if (confirm(`Change the application status to ${form.status}?`)) {
    // Proceed with updating the status
    form.put(route('company.company.updateApplicationStatus', { applicationId: props.application.id }), {
      onSuccess: () => {
        alert('Application status updated!');
        previousStatus = form.status; // Update the stored previous status
        props.application.status = form.status; // Update locally
      },
      onError: (errors) => {
        console.error(errors);
        alert('There was an issue updating the application status.');
        form.status = previousStatus; // Revert to previous status on error
      },
    });
  } else {
    // Revert to the previous status if canceled
    form.status = previousStatus;
  }
};
</script>

<style>
/* Add modern dropdown arrow alignment and styling */
select {
  background-image: none;
}

/* Improve hover interactivity */
select:hover {
  background-color: #f9f9f9;
}

/* Enhance focus appearance with smooth transitions */
select:focus {
  box-shadow: 0 0 10px rgba(0, 255, 171, 0.5);
}

/* Styling for the down arrow */
select::-ms-expand {
  display: none; /* Hide default arrow in Edge */
}
</style>
