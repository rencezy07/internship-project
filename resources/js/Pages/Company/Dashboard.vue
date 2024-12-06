<script setup>
import { usePage } from '@inertiajs/vue3';

// Access the shared auth data
const { props } = usePage();
const company = props.auth.user; // Authenticated admin's data
</script>

<template>

  <div>
    <h1 class="text-2xl font-bold mb-4">Welcome, {{ company.company_name }}!</h1>
    <p>This is your admin dashboard.</p>
  </div>

</template>
