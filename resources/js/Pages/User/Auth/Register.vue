<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  first_name: "",
  last_name: "",
  email: "",
  password: "",
  password_confirmation: "",
  dob: "",
  phone_number: "",
  gender: "male",
  university: "",
  college_level: "freshman",
  profile_picture: null,
});

const submit = () => {
  form.post(route("user.register"), {
    onFinish: () => form.reset("password"),
  });
};

const handleFileChange = (e) => {
  form.profile_picture = e.target.files[0];
};
</script>

<template>
  <div class="flex h-screen items-center justify-center text-white px-4">
    <div class="w-full max-w-xl bg-white text-black rounded-lg shadow-lg px-6 py-8">
      <h1 class="text-lg md:text-xl font-extrabold text-center text-black mb-6">
        Create Your Account
      </h1>

         <!-- Display All Errors Below the Heading -->
         <div v-if="Object.keys(form.errors).length" class="bg-red-100 text-red-600 p-4 rounded-md mb-6">
        <ul class="list-disc pl-5">
          <li v-for="(error, field) in form.errors" :key="field">
            {{ error }}
          </li>
        </ul>
      </div>

      <!-- Responsive Form -->
      <form
        @submit.prevent="submit"
        class="grid grid-cols-1 md:grid-cols-2 gap-4"
      >
        <!-- First Name -->
        <div class="relative">
          <i class="fas fa-user absolute top-3 left-3 text-gray-400"></i>
          <input
            v-model="form.first_name"
            type="text"
            placeholder="First Name"
            required
            class="w-full pl-10 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-sm md:text-base"
          />
        </div>

        <!-- Last Name -->
        <div class="relative">
          <i class="fas fa-user absolute top-3 left-3 text-gray-400"></i>
          <input
            v-model="form.last_name"
            type="text"
            placeholder="Last Name"
            required
            class="w-full pl-10 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-sm md:text-base"
          />
        </div>

        <!-- Email -->
        <div class="relative">
          <i class="fas fa-envelope absolute top-3 left-3 text-gray-400"></i>
          <input
            v-model="form.email"
            type="email"
            placeholder="Email"
            required
            class="w-full pl-10 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-sm md:text-base"
          />
          <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">
            {{ form.errors.email }}
          </div>
        </div>

        <!-- Password -->
        <div class="relative">
          <i class="fas fa-lock absolute top-3 left-3 text-gray-400"></i>
          <input
            v-model="form.password"
            type="password"
            placeholder="Password"
            required
            class="w-full pl-10 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-sm md:text-base"
          />
        </div>

        <!-- Confirm Password -->
        <div class="relative">
          <i class="fas fa-lock absolute top-3 left-3 text-gray-400"></i>
          <input
            v-model="form.password_confirmation"
            type="password"
            placeholder="Confirm Password"
            required
            class="w-full pl-10 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-sm md:text-base"
          />
        </div>

        <!-- Date of Birth -->
        <div class="relative">
          <i class="fas fa-calendar-alt absolute top-3 left-3 text-gray-400"></i>
          <input
            v-model="form.dob"
            type="date"
            required
            class="w-full pl-10 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-sm md:text-base"
          />
        </div>

        <!-- Phone Number -->
        <div class="relative">
          <i class="fas fa-phone absolute top-3 left-3 text-gray-400"></i>
          <input
            v-model="form.phone_number"
            type="tel"
            placeholder="Phone Number"
            required
            class="w-full pl-10 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-sm md:text-base"
          />
        </div>

        <!-- Gender -->
        <div class="relative">
          <i class="fas fa-venus-mars absolute top-3 left-3 text-gray-400"></i>
          <select
            v-model="form.gender"
            required
            class="w-full pl-10 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-sm md:text-base"
          >
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
        </div>

        <!-- University -->
        <div class="relative">
          <i class="fas fa-university absolute top-3 left-3 text-gray-400"></i>
          <input
            v-model="form.university"
            type="text"
            placeholder="University"
            required
            class="w-full pl-10 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-sm md:text-base"
          />
        </div>

        <!-- College Level -->
        <div class="relative">
          <i class="fas fa-graduation-cap absolute top-3 left-3 text-gray-400"></i>
          <select
            v-model="form.college_level"
            required
            class="w-full pl-10 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-sm md:text-base"
          >
            <option value="freshman">Freshman</option>
            <option value="sophomore">Sophomore</option>
            <option value="junior">Junior</option>
            <option value="senior">Senior</option>
          </select>
        </div>

        <!-- Profile Picture -->
        <div class="relative col-span-1 md:col-span-2">
          <i class="fas fa-camera absolute top-3 left-3 text-gray-400"></i>
          <input
            type="file"
            @change="handleFileChange"
            required
            class="w-full pl-10 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-sm md:text-base"
          />
        </div>

        <!-- Submit Button -->
        <div class="col-span-1 md:col-span-2 flex justify-center">
          <button
            type="submit"
            class="w-full md:w-1/2 py-2 bg-[#00FFAB] text-black font-bold rounded-md hover:bg-[#00E6A0] transition duration-300 transform hover:scale-105"
          >
            Register
          </button>
        </div>
      </form>
    </div>
  </div>
</template>


<style scoped>
/* Smooth transitions for inputs and buttons */
input,
select,
button {
  transition: border 0.3s, box-shadow 0.3s, background-color 0.3s, transform 0.3s;
}
</style>
