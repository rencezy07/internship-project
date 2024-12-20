<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

const page = usePage();
const company = page.props.company;

const form = useForm({
    company_name: company.company_name || "",
    email: company.email || "",
    location: company.location || "",
    company_logo: null,
    business_permit: null,
    password: "",
    new_password: "",
    confirm_password: "",
});

const submit = () => {
    form.post(route("company.profile.update"), {
        onFinish: () => {
            form.reset("password", "new_password", "confirm_password");
            form.clearErrors("password", "new_password", "confirm_password");
        },
    });
};
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex flex-col items-center py-10 px-4">
        <h1
            class="text-4xl font-extrabold text-gray-800 mb-8 text-center tracking-wide"
        >
            ✨ Company Profile
        </h1>
        <div
            v-if="form.errors"
            class="text-red-500 mb-4 text-center bg-red-100 p-4 rounded-lg shadow-md max-w-lg"
        >
            <p
                v-for="(error, field) in form.errors"
                :key="field"
                class="text-sm font-medium"
            >
                {{ error }}
            </p>
        </div>

        <form
            @submit.prevent="submit"
            class="ml-60 w-full max-w-3xl bg-white p-8 rounded-xl shadow-xl border border-gray-200"
        >
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Column 1 -->
                <div class="space-y-8">
                    <div>
                        <label
                            for="company_name"
                            class="block text-sm font-medium text-gray-600 mb-2"
                        >
                            🏢 Company Name
                        </label>
                        <input
                            v-model="form.company_name"
                            id="company_name"
                            type="text"
                            class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Enter your company name"
                            required
                        />
                    </div>

                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-600 mb-2"
                        >
                            📧 Email
                        </label>
                        <input
                            v-model="form.email"
                            id="email"
                            type="email"
                            class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Enter your email"
                            required
                        />
                    </div>

                    <div>
                        <label
                            for="location"
                            class="block text-sm font-medium text-gray-600 mb-2"
                        >
                            📍 Location
                        </label>
                        <input
                            v-model="form.location"
                            id="location"
                            type="text"
                            class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Enter your location"
                            required
                        />
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="space-y-8">
                    <div>
                        <label
                            for="company_logo"
                            class="block text-sm font-medium text-gray-600 mb-2"
                        >
                            🌟 Company Logo
                        </label>
                        <input
                            @change="form.company_logo = $event.target.files[0]"
                            id="company_logo"
                            type="file"
                            accept="image/*"
                            class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:outline-none transition duration-200"
                        />
                    </div>

                    <div>
                        <label
                            for="business_permit"
                            class="block text-sm font-medium text-gray-600 mb-2"
                        >
                            📜 Business Permit
                        </label>
                        <input
                            @change="
                                form.business_permit = $event.target.files[0]
                            "
                            id="business_permit"
                            type="file"
                            accept=".pdf"
                            class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:outline-none transition duration-200"
                        />
                    </div>
                </div>

                <!-- Column 3 -->
                <div class="space-y-8">
                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-600 mb-2"
                        >
                            🔑 Current Password
                        </label>
                        <input
                            v-model="form.password"
                            id="password"
                            type="password"
                            class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Enter your current password"
                            required
                        />
                    </div>

                    <div>
                        <label
                            for="new_password"
                            class="block text-sm font-medium text-gray-600 mb-2"
                        >
                            🔒 New Password
                        </label>
                        <input
                            v-model="form.new_password"
                            id="new_password"
                            type="password"
                            class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Enter a new password (optional)"
                        />
                    </div>

                    <div>
                        <label
                            for="confirm_password"
                            class="block text-sm font-medium text-gray-600 mb-2"
                        >
                            🔒 Confirm Password
                        </label>
                        <input
                            v-model="form.confirm_password"
                            id="confirm_password"
                            type="password"
                            class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Confirm your new password"
                        />
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <button
                    type="submit"
                    class="bg-[#00FFAB] text-black px-8 py-3 rounded-full font-bold text-lg shadow-lg hover:from-blue-600 hover:to-blue-800 transition duration-200 transform hover:scale-105"
                >
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</template>

<style>
/* Add a gradient background for a modern feel */
body {
    background: linear-gradient(135deg, #f0f4f8, #d9e3f0);
}
</style>
