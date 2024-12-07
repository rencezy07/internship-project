<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  application: Object, // Expect an application object with `id` and `status`
});

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

<template>
  <div class="flex items-center gap-2">
    <!-- Dropdown for changing application status -->
    <form class="flex items-center gap-2">
      <label for="status" class="sr-only">Application Status:</label>
      <select
        v-model="form.status"
        name="status"
        class="text-slate-800 bg-slate-200 text-xs py-1 border-0 outline-0 rounded-lg"
        @change="submit"
      >
        <option value="under review" class="text-slate-700">Under Review</option>
        <option value="accepted">Accepted</option>
        <option value="rejected">Rejected</option>
      </select>
    </form>
  </div>
</template>
