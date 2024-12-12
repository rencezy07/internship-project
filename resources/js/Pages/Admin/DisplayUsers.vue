<script setup>
import { ref } from 'vue';

const props = defineProps({
  users: {
    type: Array,
    default: () => [], // Ensure users is always an array
  },
});

// Safely log the users data
if (props.users && Array.isArray(props.users)) {
  console.log("Users data:", props.users);
} else {
  console.log("Users prop is missing or invalid.");
}
</script>

<template>
  <div class="p-6 bg-gray-100">
    <h1 class="text-2xl font-bold mb-4">View Users</h1>
    <table class="w-full bg-white shadow rounded">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="p-3">Profile Picture</th>
          <th class="p-3">First Name</th>
          <th class="p-3">Last Name</th>
          <th class="p-3">Email</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id" class="border-t">
          <td class="p-3">
            <img
              :src="user.profile_picture || 'https://via.placeholder.com/50'"
              alt="Profile Picture"
              class="w-12 h-12 rounded-full"
            />
          </td>
          <td class="p-3">{{ user.first_name }}</td>
          <td class="p-3">{{ user.last_name }}</td>
          <td class="p-3">{{ user.email }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
