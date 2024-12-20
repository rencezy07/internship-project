<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const showPassword = ref(false);

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

const submit = () => {
    form.post(route("admin.login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <!-- Main Container -->
        <div
            class="flex w-full max-w-8xl bg-white shadow-lg rounded-lg overflow-hidden"
        >
            <!-- Left Side: Image -->
            <!-- Left Image Section -->
            <div class="hidden md:block w-1/2">
                <img
                    src="/public/images/admin-login.webp"
                    alt="Login Image"
                    class="object-cover w-full h-full"
                />
            </div>

            <!-- Right Side: Login Form -->
            <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
                <div class="flex items-center">
                    <img
                        src="/public/images/logo.png"
                        alt="Logo"
                        class="h-15 w-15"
                    />
                </div>
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-4xl font-extrabold text-gray-800">
                        Admin Login
                    </h2>
                    <p class="text-gray-600 mt-2">Access your admin panel</p>
                    <div
                        class="h-1 w-16 bg-[#00FFAB] mx-auto mt-3 rounded"
                    ></div>
                </div>

                <!-- Form -->
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Email Field -->
                    <div>
                        <label
                            for="email"
                            class="block text-gray-700 font-medium mb-2"
                            >Email</label
                        >
                        <div class="relative">
                            <span class="absolute left-3 top-3.5 text-gray-400"
                                >📧</span
                            >
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                placeholder="Enter your email"
                                class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#00FFAB] focus:border-[#00FFAB] transition duration-300"
                                required
                            />
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label
                            for="password"
                            class="block text-gray-700 font-medium mb-2"
                            >Password</label
                        >
                        <div class="relative">
                            <span class="absolute left-3 top-3.5 text-gray-400"
                                >🔒</span
                            >
                            <input
                                id="password"
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                placeholder="Enter your password"
                                class="w-full pl-10 pr-12 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#00FFAB] focus:border-[#00FFAB] transition duration-300"
                                required
                            />
                            <!-- Show/Hide Password Icon -->
                            <button
                                type="button"
                                @click="togglePasswordVisibility"
                                class="absolute right-3 top-3.5 text-gray-500 hover:text-gray-700"
                            >
                                <span>{{ showPassword ? "🙈" : "👁️" }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label
                            class="flex items-center space-x-2 text-sm text-gray-700"
                        >
                            <input
                                type="checkbox"
                                v-model="form.remember"
                                class="rounded border-gray-300 focus:ring-[#00FFAB]"
                            />
                            <span>Remember Me</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button
                            type="submit"
                            class="w-1/2 bg-[#00FFAB] text-black font-bold py-2 rounded-full hover:bg-black hover:text-white transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#00FFAB] focus:ring-offset-2"
                        >
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
