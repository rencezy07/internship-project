<script setup>
import { useForm } from "@inertiajs/vue3";

// Define props passed to the component
const props = defineProps({ company: Object });

// Initialize form with the company verification status
const form = useForm({ isVerified: props.company.isVerified });

const submit = () => {
  console.log('Submitting form:', form);

  form.put(route("admin.companyapp.update", { company_id: props.company.company_id }), {
    onSuccess: () => {
        alert("Status updated successfully!");
    },
    onError: (errors) => {
        console.error("Error during update:", errors);
        alert("An error occurred while updating the status.");
    },
});

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
