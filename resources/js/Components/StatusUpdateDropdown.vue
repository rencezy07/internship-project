<script setup>
import { useForm } from '@inertiajs/vue3';

// Define props to pass the application object
const props = defineProps({
  application: Object,
});

// Initialize form with the current application status
const form = useForm({
  status: props.application.status,
});

// Handle the form submission to update the application status
const submit = () => {
  if (confirm(`Change the application status to ${form.status}?`)) {
    form.put(route('company.company.updateApplicationStatus', { applicationId: props.application.id }), {
      onSuccess: () => {
        alert('Application status updated!');
      },
      onError: (errors) => {
        console.error(errors);
        alert('There was an issue updating the application status.');
      },
    });
  } else {
    // Optionally, reset the status if the user cancels
    form.status = props.application.status;
  }
};
</script>

<template>
  <div class="flex items-center gap-2">
    <!-- Dropdown for changing application status -->
    <form @change="submit" class="flex items-center gap-2">
      <label for="status" class="sr-only">Application Status:</label>
      <select
        v-model="form.status"
        name="status"
        class="text-slate-800 bg-slate-200 text-xs py-1 border-0 outline-0 rounded-lg"
      >
        <option value="under review">Under Review</option>
        <option value="accepted">Accepted</option>
        <option value="rejected">Rejected</option>
      </select>
    </form>
  </div>
</template>
