<script setup>
import { useForm } from "@inertiajs/vue3";

// Define props passed to the component
const props = defineProps({ company: Object });

// Initialize form with the company verification status
const form = useForm({ isVerified: props.company.isVerified });

// Function to handle the submit action
const submit = () => {
    // Confirm before updating the status
    if (confirm(`Change this company's approval status to ${form.isVerified ? 'Verified' : 'Not Verified'}?`)) {
        // Use Ziggy's route helper to generate the URL for the update route
        form.put(route("admin.companyapp.update", { company: props.company.id }));
    } else {
        // Revert the status if the user cancels
        form.isVerified = props.company.isVerified;
    }
};
</script>

<template>
  <div class="flex items-center gap-2">
    <!-- Use a form to trigger the submit on change -->
    <form @change="submit" class="flex items-center gap-2">
      <label for="approvalStatus" class="sr-only">Approval Status:</label>
      <select
        v-model="form.isVerified"
        name="approvalStatus"
        class="text-slate-800 bg-slate-200 text-xs py-1 border-0 outline-0 rounded-lg"
      >
        <option :value="true">Verified</option>
        <option :value="false">Not Verified</option>
      </select>
    </form>
  </div>
</template>
