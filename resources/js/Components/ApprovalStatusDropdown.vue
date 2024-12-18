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
    <!-- Approval Status Dropdown -->
    <form @change="submit" class="relative">
      <label for="approvalStatus" class="sr-only">Approval Status:</label>
      <select
        v-model="form.isVerified"
        name="approvalStatus"
        class="block w-40 px-3 py-2 text-sm font-semibold text-gray-800 border-0 rounded-lg shadow-md bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#00FFAB] transition-all"
      >
        <option :value="true" class="text-green-600">Verified</option>
        <option :value="false" class="text-red-600">Not Verified</option>
      </select>

      <!-- Visual Indicator -->
      <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
        <span
          v-if="form.isVerified"
          class="inline-block w-3 h-3 bg-green-500 rounded-full animate-pulse"
        ></span>
        <span
          v-else
          class="inline-block w-3 h-3 bg-red-500 rounded-full animate-pulse"
        ></span>
      </div>
    </form>
  </div>
</template>

<style>
/* Custom styling for the dropdown animation */
select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
}

select::-ms-expand {
  display: none;
}
</style>
