<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  email: '',
  password: '',
});

const submit = () => {
  form.post(route('company.login'), {
    onFinish: () => form.reset('password'), // Clear password field after submit
  });
};
</script>

<template>
  <div>
    <h1>Company Login</h1>

    <!-- Display error messages -->
    <div v-if="form.errors.email" class="text-red-500 mb-4">
      <p>{{ form.errors.email }}</p>
    </div>

    <form @submit.prevent="submit">
      <input
        v-model="form.email"
        type="email"
        name="email"
        placeholder="Email"
        required
      />
      <input
        v-model="form.password"
        type="password"
        name="password"
        placeholder="Password"
        required
      />
      <label>
        <input type="checkbox" v-model="form.remember" />
        Remember Me
      </label>
      <button type="submit">Login</button>
    </form>
  </div>
</template>
