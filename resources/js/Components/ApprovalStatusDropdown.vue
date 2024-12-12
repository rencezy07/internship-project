<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  company: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  isVerified: props.company.isVerified, // Initialize with current isVerified value
});

const updateStatus = () => {
  form.put(route('admin.companyapp.update', { company: props.company.company_id }), {
    onSuccess: () => {
      alert('Status updated successfully!');
    },
    onError: () => {
      alert('Error updating status.');
    },
  });
};
</script>

<template>
  <div>
    <select v-model="form.isVerified" @change="updateStatus" class="border rounded">
      <option :value="true">Verified</option>
      <option :value="false">Not Verified</option>
    </select>
  </div>
</template>
