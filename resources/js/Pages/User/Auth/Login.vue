<script setup>
import { useForm } from "@inertiajs/vue3";

// Google Login
const googleLogin = () => {
    window.location.href = "/auth/google"; // Redirect to Google login route
};

// Form Submission
const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("user.login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <div class="flex h-screen">
        <!-- Left Section: Branding -->
        <div
            class="hidden sm:flex w-1/2 bg-black text-white items-center justify-center"
        >
            <div class="text-center px-8">
                <img
                    src="/public/images/internship-logo.png"
                    alt="OpportuniSeek Logo"
                    class="h-16 w-17 mb-4 mx-auto"
                />
                <h2 class="text-3xl font-extrabold">Welcome Back!</h2>
                <p class="mt-2 text-lg leading-relaxed">
                    Your journey to success starts here with
                    <span class="text-[#00FFAB] font-bold">OpportuniSeek</span>.
                </p>
            </div>
        </div>

        <!-- Right Section: Login Form -->
        <div
            class="w-full sm:w-1/2 flex flex-col justify-center items-center px-6 py-8 bg-white"
        >
            <div class="w-full max-w-sm">
                <h1 class="text-2xl font-extrabold text-center text-black mb-6">
                    Student Login
                </h1>

                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Email Field -->
                    <div>
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="Email"
                            required
                            class="w-full p-3 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-black"
                            :class="{ 'border-red-500': form.errors.email }"
                        />
                        <div
                            v-if="form.errors.email"
                            class="text-red-500 text-sm mt-1"
                        >
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <input
                            v-model="form.password"
                            type="password"
                            placeholder="Password"
                            required
                            class="w-full p-3 border border-black rounded-md focus:outline-none focus:ring-2 focus:ring-[#00FFAB] text-black"
                        />
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center justify-between">
                        <label
                            class="flex items-center space-x-2 text-sm text-gray-600"
                        >
                            <input
                                type="checkbox"
                                v-model="form.remember"
                                class="text-[#00FFAB] focus:ring-[#00FFAB]"
                            />
                            <span class="text-black">Remember Me</span>
                        </label>
                        <a
                            href="/forgot-password"
                            class="text-sm text-[#00FFAB] hover:underline"
                            >Forgot Password?</a
                        >
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full py-2 bg-[#00FFAB] text-black font-semibold rounded-md hover:bg-[#00E6A0] transition duration-300 transform hover:scale-105"
                    >
                        Login
                    </button>

                    <!-- Divider -->
                    <div class="relative flex items-center my-4">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="mx-4 text-gray-500">OR</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>

                    <!-- Google Login -->
                    <button
                        @click.prevent="googleLogin"
                        class="w-full flex items-center justify-center py-2 border border-gray-300 rounded-md shadow-sm hover:bg-gray-100 transition duration-300"
                    >
                        <img
                            src="/public/images/google-logo.png"
                            alt="Google Logo"
                            class="h-5 w-5 mr-2"
                        />
                        <span class="text-gray-700 font-medium"
                            >Sign in with Google</span
                        >
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
input {
    transition: border 0.3s, box-shadow 0.3s;
}

button {
    transition: background-color 0.3s, transform 0.2s;
}
</style>
