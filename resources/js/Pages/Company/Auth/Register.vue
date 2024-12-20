<template>
    <div class="min-h-screen flex items-center justify-center bg-white">
        <!-- Container -->
        <div
            class="flex w-full max-w-5xl bg-white shadow-lg rounded-lg overflow-hidden"
        >
            <!-- Left Section: Image -->
            <div
                class="hidden md:block md:w-1/2 bg-gray-100 flex items-center justify-center"
            >
                <img
                    src="/public/images/company-register.png"
                    alt="Company Image"
                    class="w-full h-auto max-h-[400px] object-contain mx-auto"
                />
            </div>

            <!-- Right Section: Form -->
            <div
                class="w-full md:w-1/2 bg-white p-8 flex flex-col justify-center"
            >
                <!-- Form Header -->
                <h2 class="text-3xl font-bold text-black mb-6 text-center">
                    Register Your Company
                </h2>
                <div class="h-1 w-16 bg-[#00FFAB] mx-auto mb-6 rounded"></div>

                <!-- Form -->
                <form @submit.prevent="submit">
                    <!-- Two Column Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Company Name -->
                        <div>
                            <label
                                for="company_name"
                                class="block text-sm font-medium text-black"
                                >Company Name</label
                            >
                            <input
                                v-model="form.company_name"
                                type="text"
                                id="company_name"
                                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#00FFAB] focus:outline-none"
                                placeholder="Company name"
                                required
                            />
                        </div>

                        <!-- Email -->
                        <div>
                            <label
                                for="email"
                                class="block text-sm font-medium text-black"
                                >Email</label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                id="email"
                                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#00FFAB] focus:outline-none"
                                placeholder="example@domain.com"
                                required
                            />
                        </div>

                        <!-- Password -->
                        <div>
                            <label
                                for="password"
                                class="block text-sm font-medium text-black"
                                >Password</label
                            >
                            <input
                                v-model="form.password"
                                type="password"
                                id="password"
                                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#00FFAB] focus:outline-none"
                                placeholder="••••••••"
                                required
                            />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label
                                for="password_confirmation"
                                class="block text-sm font-medium text-black"
                                >Confirm Password</label
                            >
                            <input
                                v-model="form.password_confirmation"
                                type="password"
                                id="password_confirmation"
                                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#00FFAB] focus:outline-none"
                                placeholder="Re-enter password"
                                required
                            />
                        </div>

                        <!-- Location: Full Row -->
                        <div class="col-span-2">
                            <label
                                for="location"
                                class="block text-sm font-medium text-black"
                                >Location</label
                            >
                            <input
                                v-model="form.location"
                                type="text"
                                id="location"
                                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#00FFAB] focus:outline-none"
                                placeholder="e.g., City, Country"
                                required
                            />
                        </div>

                        <!-- Company Logo -->
                        <div>
                            <label
                                for="company_logo"
                                class="block text-sm font-medium text-black"
                                >Company Logo</label
                            >
                            <input
                                type="file"
                                id="company_logo"
                                name="company_logo"
                                @change="handleFileChange"
                                class="mt-1 w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-white file:bg-[#00FFAB] hover:file:bg-black transition duration-300"
                                accept="image/*"
                                required
                            />
                        </div>

                        <!-- Business Permit -->
                        <div>
                            <label
                                for="business_permit"
                                class="block text-sm font-medium text-black"
                                >Business Permit</label
                            >
                            <input
                                type="file"
                                id="business_permit"
                                name="business_permit"
                                @change="handleFileChange"
                                class="mt-1 w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-white file:bg-[#00FFAB] hover:file:bg-black transition duration-300"
                                accept=".pdf,.docx,.doc"
                                required
                            />
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-6">
                        <button
                            type="submit"
                            class="w-full bg-[#00FFAB] text-black font-bold py-2 rounded-md hover:bg-black hover:text-white transition duration-300"
                        >
                            Register Company
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    company_name: "",
    email: "",
    password: "",
    password_confirmation: "",
    location: "",
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
    form.post(route("company.register"), {
        onSuccess: () => {
            alert("Company registered successfully!");
        },
        onError: (errors) => {
            console.error(errors); // Log errors for debugging
        },
    });
};
</script>
