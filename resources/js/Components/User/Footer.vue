<template>
    <footer class="bg-black text-[#00FFAB] py-10">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- About Section -->
            <div>
                <h3 class="text-white font-extrabold text-xl mb-4">About OpportuniSeek</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-[#B5B5B6]">About us</a></li>
                </ul>
            </div>

            <!-- Partnerships Section -->
            <div>
                <h3 class="text-white font-extrabold text-xl mb-4">Partnerships</h3>
                <ul class="space-y-2">
                    <li><a :href="route('company.login')" class="hover:text-[#B5B5B6]">Are you a company looking for interns? Login here.</a></li>
                </ul>
            </div>

            <!-- Terms Section -->
            <div>
                <h3 class="text-white font-extrabold text-xl mb-4">Terms of Use</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-[#B5B5B6]">General terms of use</a></li>
                    <li><a href="#" class="hover:text-[#B5B5B6]">Privacy policy</a></li>
                    <li><a href="#" class="hover:text-[#B5B5B6]">Cookie policy</a></li>
                </ul>
            </div>
        </div>

        <!-- Social Media Section -->
        <div class="mt-10 text-center">
            <p class="text-white font-semibold text-lg mb-4">Follow us on</p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="hover:text-[#B5B5B6]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24h21.351c.731 0 1.324-.593 1.324-1.324V1.325C24 .593 23.407 0 22.675 0zM7.188 20.452H3.547v-9.597h3.641v9.597zM5.368 9.338c-1.176 0-2.126-.95-2.126-2.126S4.192 5.086 5.368 5.086c1.176 0 2.126.95 2.126 2.126 0 1.177-.95 2.126-2.126 2.126zm15.084 11.114h-3.641v-4.994c0-1.191-.021-2.724-1.659-2.724-1.66 0-1.913 1.297-1.913 2.633v5.085h-3.641v-9.597h3.494v1.313h.049c.487-.922 1.676-1.897 3.449-1.897 3.687 0 4.368 2.427 4.368 5.584v5.598z" />
                    </svg>
                </a>
                <a href="#" class="hover:text-[#B5B5B6]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 4.557a9.864 9.864 0 01-2.828.775A4.939 4.939 0 0023.337 3.1a9.868 9.868 0 01-3.127 1.195 4.92 4.92 0 00-8.388 4.482A13.978 13.978 0 011.671 3.149 4.922 4.922 0 003.148 9.74a4.903 4.903 0 01-2.229-.616v.062a4.923 4.923 0 003.946 4.827 4.939 4.939 0 01-2.224.084 4.928 4.928 0 004.6 3.419A9.869 9.869 0 010 19.539a13.936 13.936 0 007.548 2.212c9.142 0 14.307-7.721 14.307-14.424 0-.22-.005-.439-.015-.657A10.243 10.243 0 0024 4.557z" />
                    </svg>
                </a>
                <a href="#" class="hover:text-[#B5B5B6]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.849.07 1.366.062 2.633.33 3.608 1.305.975.975 1.244 2.242 1.305 3.608.058 1.265.069 1.645.069 4.849s-.012 3.584-.069 4.849c-.062 1.366-.33 2.633-1.305 3.608-.975.975-2.242 1.244-3.608 1.305-1.265.058-1.645.069-4.849.069s-3.584-.012-4.849-.069c-1.366-.062-2.633-.33-3.608-1.305-.975-.975-1.244-2.242-1.305-3.608-.058-1.265-.069-1.645-.069-4.849s.012-3.584.069-4.849c.062-1.366.33-2.633 1.305-3.608.975-.975 2.242-1.244 3.608-1.305 1.265-.058 1.645-.069 4.849-.069m0-2.163C8.755 0 8.334.012 7.052.07 5.705.13 4.436.4 3.359 1.477 2.282 2.554 2.012 3.823 1.953 5.17.894 5.31 0 8.755 0 12s.012 3.584.07 4.849c.062 1.366.33 2.633 1.305 3.608.975.975 2.242 1.244 3.608 1.305 1.265.058 1.645.069 4.849.069s3.584-.012 4.849-.069c1.366-.062 2.633-.33 3.608-1.305.975-.975 1.244-2.242 1.305-3.608.058-1.265.069-1.645.069-4.849s-.012-3.584-.069-4.849c-.062-1.366-.33-2.633-1.305-3.608-.975-.975-2.242-1.244-3.608-1.305C15.584.012 15.204 0 12 0z" />
                        <path d="M12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a3.999 3.999 0 110-8.001 3.999 3.999 0 010 8.001zm6.406-11.845a1.44 1.44 0 100 2.882 1.44 1.44 0 000-2.882z" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="bg-[#7D7D7D] text-center text-[#B5B5B6] py-4 mt-8 ">
            <p class="font-medium">2024 OpportuniSeek | All rights reserved.</p>
        </div>
    </footer>
</template>

<script setup>
// No additional logic for now; static component
</script>

<style scoped>
footer {
    font-family: 'Arial', sans-serif;
}
</style>
