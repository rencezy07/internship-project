<script setup>
import { ref } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';

// Reactive state for editing mode
const editingInternship = ref(null);

// Retrieve internships from props passed via Inertia
const { internships } = usePage().props;

// Initialize the form using useForm
const form = useForm({
  internship_id: null,
  internship_name: '',
  city: '',
  salary: '',
  is_open: true,
});

// Function to set the internship in edit mode
const editInternship = (internship) => {
  editingInternship.value = internship; // Set editing mode
  form.internship_id = internship.internship_id; // Populate form with existing data
  form.internship_name = internship.internship_name;
  form.city = internship.city;
  form.salary = internship.salary;
  form.is_open = internship.is_open;
};

// Function to save the internship
const saveInternship = () => {
  form.put(route('company.update', { internshipId: form.internship_id }), {
    onSuccess: () => {
      // Find the index of the updated internship in the array
      const index = internships.findIndex(
        (internship) => internship.internship_id === form.internship_id
      );

      // Update the internship in the local array
      if (index !== -1) {
        internships[index] = { ...internships[index], ...form };
      }

      editingInternship.value = null; // Exit editing mode
      form.reset(); // Clear the form
      alert('Internship updated successfully!');
    },
    onError: () => {
      alert('Failed to update internship. Please check your input.');
    },
  });
};


// Function to cancel editing
const cancelEditing = () => {
  editingInternship.value = null; // Exit editing mode
  form.reset(); // Reset the form fields
};

// Function to delete an internship
const deleteInternship = (internshipId) => {
  if (confirm('Are you sure you want to delete this internship?')) {
    form.delete(route('company.delete', { internshipId }), {
      onSuccess: () => {
        // Remove the deleted internship from the local array
        const index = internships.findIndex(
          (internship) => internship.internship_id === internshipId
        );
        if (index !== -1) {
          internships.splice(index, 1);
        }

        alert('Internship deleted successfully!');
      },
      onError: () => {
        alert('Failed to delete internship. Please try again.');
      },
    });
  }
};
</script>

<template>
  <div>
    <!-- Internship List -->
    <table>
      <thead>
        <tr>
          <th>Internship Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="internship in internships" :key="internship.internship_id">
          <td>{{ internship.internship_name }}</td>
          <td>
            <button @click="editInternship(internship)">Edit</button>
            <button @click="deleteInternship(internship.internship_id)" class="ml-2 text-red-600">Delete</button>

          </td>
        </tr>
      </tbody>
    </table>

    <!-- Edit Form -->
    <div v-if="editingInternship" class="mt-4">
      <form @submit.prevent="saveInternship">
        <div>
          <label>Internship Name:</label>
          <input v-model="form.internship_name" type="text" required />
        </div>
        <div>
          <label>City:</label>
          <input v-model="form.city" type="text" required />
        </div>
        <div>
          <label>Salary:</label>
          <input v-model="form.salary" type="number" required />
        </div>
        <div>
          <label>
            <input type="checkbox" v-model="form.is_open" />
            Open Status
          </label>
        </div>
        <div class="mt-2">
          <button type="submit" :disabled="form.processing">Save</button>
          <button type="button" @click="cancelEditing">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</template>
