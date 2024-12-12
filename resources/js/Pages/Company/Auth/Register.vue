<template>
    <div class="max-w-2xl mx-auto bg-white p-8 shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Register Company</h2>

        <form @submit.prevent="submit">
            <!-- Company Name -->
            <div class="mb-4">
                <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                <input
                    v-model="form.company_name"
                    type="text"
                    id="company_name"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    required
                />
                <div v-if="form.errors.company_name" class="text-red-500 text-sm mt-1">
                    {{ form.errors.company_name }}
                </div>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    v-model="form.email"
                    type="email"
                    id="email"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    required
                />
                <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">
                    {{ form.errors.email }}
                </div>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                    v-model="form.password"
                    type="password"
                    id="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    required
                />
                <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">
                    {{ form.errors.password }}
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input
                    v-model="form.password_confirmation"
                    type="password"
                    id="password_confirmation"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    required
                />
                <div v-if="form.errors.password_confirmation" class="text-red-500 text-sm mt-1">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>

            <!-- Location -->
            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <input
                    v-model="form.location"
                    type="text"
                    id="location"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    required
                />
                <div v-if="form.errors.location" class="text-red-500 text-sm mt-1">
                    {{ form.errors.location }}
                </div>
            </div>

            <!-- Company Logo -->
            <div class="mb-4">
                <label for="company_logo" class="block text-sm font-medium text-gray-700">Company Logo</label>
                <input
                    type="file"
                    id="company_logo"
                    name="company_logo"
                    @change="handleFileChange"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    accept="image/*"
                    required
                />
                <div v-if="form.errors.company_logo" class="text-red-500 text-sm mt-1">
                    {{ form.errors.company_logo }}
                </div>
            </div>

            <!-- Business Permit -->
            <div class="mb-4">
                <label for="business_permit" class="block text-sm font-medium text-gray-700">Business Permit</label>
                <input
                    type="file"
                    id="business_permit"
                    name="business_permit"
                    @change="handleFileChange"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    accept=".pdf,.docx,.doc"
                    required
                />
                <div v-if="form.errors.business_permit" class="text-red-500 text-sm mt-1">
                    {{ form.errors.business_permit }}
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button
                    type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-indigo-700 focus:outline-none"
                >
                    Register Company
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    company_name: '',
    email: '',
    password: '',
    password_confirmation: '',
    location: '',
    company_logo: null,
    business_permit: null,
});

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (event.target.name === "company_logo") {
        form.company_logo = file;
    } else if (event.target.name === "business_permit") {
        form.business_permit = file;
    }
};

const submit = () => {
    form.post(route('company.register'), {
        onSuccess: () => {
            alert("Company registered successfully!");
        },
        onError: (errors) => {
            console.error(errors); // Log errors for debugging
        },
    });
};
</script>
