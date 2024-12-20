<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    user: Object,
});

const form = useForm({
    first_name: props.user?.first_name || "",
    last_name: props.user?.last_name || "",
    email: props.user?.email || "",
    current_password: "", 
    new_password: "", 
    new_password_confirmation: "",
    dob: props.user?.dob || "",
    phone_number: props.user?.phone_number || "",
    gender: props.user?.gender || "male",
    university: props.user?.university || "",
    college_level: props.user?.college_level || "freshman",
    profile_picture: null,
});

const handleFileChange = (event) => {
    form.profile_picture = event.target.files[0];
};

const deleteAccount = () => {
    // Check if the current password is provided
    if (!form.current_password) {
        alert(
            "Please enter your current password to confirm account deletion."
        );
        return;
    }

    // Confirm the action with the user
    if (
        confirm(
            "Are you sure you want to delete your account? This action cannot be undone."
        )
    ) {
        form.delete(route("user.delete"), {
            data: { current_password: form.current_password },
            onSuccess: () => {
                alert("Your account has been deleted successfully.");
                // Optionally redirect to login or home page after deletion
                window.location.href = "/login"; // Or any route you'd like to redirect to
            },
            onError: (errors) => {
                // Handle errors, such as password mismatch or any other issue
                if (errors.current_password) {
                    alert(errors.current_password[0]); // Show the error message for the password field
                } else {
                    alert(
                        "There was an issue deleting your account. Please try again."
                    );
                }
            },
        });
    }
};

const submit = () => {
    if (!form.current_password) {
        alert("Please enter your current password to update your profile.");
        return;
    }

    form.post(route("user.profile.update"), {
        onSuccess: () => {
            alert("Profile updated successfully!");
            // Clear password fields after success
            form.current_password = "";
            form.new_password = "";
            form.new_password_confirmation = "";
        },
        onError: (errors) => {
            console.error(errors); // Log the errors for debugging
        },
    });
};
</script>

<template>
    <div
        class="max-w-2xl mx-auto p-6 bg-gradient-to-r from-white to-gray-50 shadow-lg rounded-lg"
    >
        <!-- Profile Header -->
        <div class="text-center mb-6">
            <div class="inline-block rounded-full p-2 bg-gray-200">
                <img
                    src="/public/images/default-profile.png"
                    alt="Profile Picture"
                    class="w-20 h-20 object-cover rounded-full border-4 border-indigo-500 shadow-lg"
                />
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mt-4">Edit Profile</h2>
            <p class="text-sm text-gray-500">
                Update your personal information and settings.
            </p>
        </div>

        <!-- Form Section -->
        <form
            @submit.prevent="submit"
            enctype="multipart/form-data"
            class="space-y-4"
        >
            <!-- Error Messages -->
            <div v-if="form.errors.email" class="text-red-500 text-sm">
                {{ form.errors.email }}
            </div>
            <div
                v-if="form.errors.current_password"
                class="text-red-500 text-sm"
            >
                {{ form.errors.current_password }}
            </div>

            <!-- Personal Information -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label
                        for="first_name"
                        class="block text-sm font-medium text-gray-700"
                        >First Name</label
                    >
                    <input
                        v-model="form.first_name"
                        type="text"
                        id="first_name"
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                        required
                    />
                </div>
                <div>
                    <label
                        for="last_name"
                        class="block text-sm font-medium text-gray-700"
                        >Last Name</label
                    >
                    <input
                        v-model="form.last_name"
                        type="text"
                        id="last_name"
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                        required
                    />
                </div>
            </div>

            <!-- Email and Phone -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                        >Email</label
                    >
                    <input
                        v-model="form.email"
                        type="email"
                        id="email"
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                        required
                    />
                </div>
                <div>
                    <label
                        for="phone_number"
                        class="block text-sm font-medium text-gray-700"
                        >Phone</label
                    >
                    <input
                        v-model="form.phone_number"
                        type="text"
                        id="phone_number"
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                        required
                    />
                </div>
            </div>

            <!-- Gender and University -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label
                        for="gender"
                        class="block text-sm font-medium text-gray-700"
                        >Gender</label
                    >
                    <select
                        v-model="form.gender"
                        id="gender"
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                        required
                    >
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label
                        for="university"
                        class="block text-sm font-medium text-gray-700"
                        >University</label
                    >
                    <input
                        v-model="form.university"
                        type="text"
                        id="university"
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                        required
                    />
                </div>
            </div>

            <!-- College Level -->
            <div>
                <label
                    for="college_level"
                    class="block text-sm font-medium text-gray-700"
                    >College Level</label
                >
                <select
                    v-model="form.college_level"
                    id="college_level"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                    required
                >
                    <option value="freshman">Freshman</option>
                    <option value="sophomore">Sophomore</option>
                    <option value="junior">Junior</option>
                    <option value="senior">Senior</option>
                </select>
            </div>

            <!-- Password Section -->
            <div>
                <label
                    for="current_password"
                    class="block text-sm font-medium text-gray-700"
                    >Current Password</label
                >
                <input
                    v-model="form.current_password"
                    type="password"
                    id="current_password"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                    required
                />
            </div>
            <div>
                <label
                    for="new_password"
                    class="block text-sm font-medium text-gray-700"
                    >New Password</label
                >
                <input
                    v-model="form.new_password"
                    type="password"
                    id="new_password"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                />
            </div>
            <div>
                <label
                    for="new_password_confirmation"
                    class="block text-sm font-medium text-gray-700"
                    >Confirm New Password</label
                >
                <input
                    v-model="form.new_password_confirmation"
                    type="password"
                    id="new_password_confirmation"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                />
            </div>

            <!-- Profile Picture -->
            <div class="mb-4">
                <label
                    for="profile_picture"
                    class="block text-sm font-medium text-gray-700"
                    >Profile Picture</label
                >
                <input
                    type="file"
                    id="profile_picture"
                    @change="handleFileChange"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                />
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button
                    type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none"
                >
                    Save Changes
                </button>
            </div>
        </form>

        <!-- Delete Account Section -->
        <div class="mt-6 bg-red-50 p-4 rounded-lg shadow-md">
            <h3 class="text-sm font-semibold text-red-700">Delete Account</h3>
            <p class="text-xs text-red-600">
                This action cannot be undone. Please confirm your password to
                delete your account.
            </p>
            <div class="text-right mt-4">
                <button
                    @click="deleteAccount"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-700 focus:outline-none"
                >
                    Delete Account
                </button>
            </div>
        </div>
    </div>
</template>
