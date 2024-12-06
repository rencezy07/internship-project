<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  email: '',
  password: '',
});

const submit = () => {
  form.post(route('user.login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <div>
    <h1>User Login</h1>
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
