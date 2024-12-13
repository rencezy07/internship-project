<script setup>
const props = defineProps({
  applications: Array, // Array of internship applications
});
console.log(props.applications);

</script>


<template>
  <div class="p-6 bg-gray-100">
    <h1 class="text-2xl font-bold mb-4">Student Internship Applications</h1>

    <table class="w-full bg-white shadow rounded">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="p-3">Applicant Name</th> <!-- Added column for Applicant's Name -->
          <th class="p-3">Internship Name</th>
          <th class="p-3">Company Name</th>
          <th class="p-3">Status</th>
          <th class="p-3">Salary</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="application in applications" :key="application.internship_name" class="border-t">
          <td class="p-3">{{ application.first_name }} {{ application.last_name }}</td> <!-- Display first_name and last_name -->
          <td class="p-3">{{ application.internship_name }}</td>
          <td class="p-3">{{ application.company_name }}</td>
          <td class="p-3">
            <span
              :class="{
                'text-green-600': application.application_status === 'approved',
                'text-red-600': application.application_status === 'rejected',
                'text-yellow-600': application.application_status === 'under review',
              }"
            >
              {{ application.application_status }}
            </span>
          </td>
          <td class="p-3">{{ application.salary }}</td>
         
        </tr>
      </tbody>
    </table>
  </div>
</template>
