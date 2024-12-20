<template>
    <div>
        <!-- Navigation Bar -->
        <nav class="bg-white shadow-md py-4 px-6">
            <div class="container mx-auto flex items-center justify-between">
                <!-- Left Side: Logo -->
                <div class="flex items-center">
                    <img
                        src="/public/images/logo.png"
                        alt="Logo"
                        class="h-15 w-15 mr-2"
                    />
                </div>

                <!-- Middle: Navigation Links -->
                <ul
                    class="hidden md:flex space-x-9 text-gray-600 font-semibold"
                >
                    <li>
                        <a
                            href="/home"
                            class="hover:text-[#113F1F] transition duration-300"
                            :class="{
                                'text-black font-bold': active === 'home',
                            }"
                            @click="setActive('home')"
                        >
                            Home
                        </a>
                    </li>
                    <li>
                        <a
                            href="#about-us"
                            class="hover:text-[#113F1F] transition duration-300"
                            :class="{
                                'text-black font-bold': active === 'about',
                            }"
                            @click="setActive('about')"
                        >
                            About Us
                        </a>
                    </li>
                    <li>
                        <a
                            href="/company/login"
                            class="hover:text-[#113F1F] transition duration-300"
                            :class="{
                                'text-black font-bold': active === 'company',
                            }"
                            @click="setActive('company')"
                        >
                            Company Login
                        </a>
                    </li>
                    <li>
                        <a
                            href="/contact"
                            class="hover:text-[#113F1F] transition duration-300"
                            :class="{
                                'text-black font-bold': active === 'contact',
                            }"
                            @click="setActive('contact')"
                        >
                            Contact
                        </a>
                    </li>
                </ul>

                <!-- Right Side: Login and Register -->
                <div class="hidden md:flex space-x-4">
                    <a
                        href="/user/login"
                        class="text-gray-600 hover:text-[#113F1F] font-medium transition duration-300 pt-2"
                    >
                        Login
                    </a>
                    <a
                        href="/user/register"
                        class="bg-[#00FFAB] text-black px-4 py-2 rounded-full font-medium hover:bg-[#4F9761] transition duration-300"
                    >
                        Register
                    </a>
                </div>

                <!-- Mobile Menu: Hamburger Icon -->
                <div class="md:hidden">
                    <button
                        @click="toggleMenu"
                        class="text-gray-600 focus:outline-none"
                    >
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Dropdown Menu -->
            <div
                v-if="isMenuOpen"
                class="md:hidden bg-white shadow-md mt-4 py-4 space-y-4 text-center text-gray-600 font-medium"
            >
                <a href="/home" @click="setActive('home')" class="block"
                    >Home</a
                >
                <a href="/about-us" @click="setActive('about')" class="block"
                    >About Us</a
                >
                <a
                    href="/company-login"
                    @click="setActive('company')"
                    class="block"
                    >Company Login</a
                >
                <a href="/contact" @click="setActive('contact')" class="block"
                    >Contact</a
                >
                <hr />
                <a href="/login" class="block">Login</a>
                <a href="/register" class="block text-[#4FB148]">Register</a>
            </div>
        </nav>

        <!-- Hero Section -->
        <section
            class="bg-gradient-to-r from-[#00FFAB] via-[#94a3b8] to-[#cbd5e1] text-black py-20 px-6 md:px-12"
        >
            <div
                class="container mx-auto flex flex-col md:flex-row items-center"
            >
                <div class="md:w-1/2">
                    <h1
                        class="text-4xl md:text-6xl font-extrabold leading-tight tracking-wide"
                    >
                        Your Pathway to Success Starts Here
                    </h1>
                    <p class="mt-6 text-lg leading-relaxed">
                        Explore opportunities, connect with top companies, and
                        secure internships that shape your future.
                    </p>
                    <div class="mt-8 flex flex-wrap space-x-6">
                        <a
                            href="/user/register"
                            class="bg-[#B5B5B6] text-[#113F1F] font-bold py-3 px-8 rounded-full shadow-md hover:bg-[#7D7D7D] hover:text-white transition duration-300 flex items-center"
                        >
                            <i class="fas fa-user-plus mr-2"></i> Get Started
                        </a>
                        <a
                            href="/user/login"
                            class="bg-[#00FFAB] text-white font-bold py-3 px-8 rounded-full shadow-md hover:bg-[#4F9761] transition duration-300 flex items-center"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i> Log In
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 mt-8 md:mt-0">
                    <img
                        src="/public/images/internship.webp"
                        alt="Internship Opportunities"
                        class="rounded-lg transform hover:scale-105 transition duration-500 mx-auto"
                    />
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="bg-[#F4F4F4] py-20 px-6">
            <div class="container mx-auto text-center">
                <h2
                    class="text-3xl md:text-4xl font-extrabold mb-12 text-[#113F1F]"
                >
                    Why Choose OpportuniSeek?
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <FeatureCard
                        icon="fas fa-briefcase"
                        title="Wide Range of Internships"
                        text="Find internships across industries tailored to your skills and interests."
                        primary-color="#00FFAB"
                        hover-color="#4FB148"
                    />
                    <FeatureCard
                        icon="fas fa-building"
                        title="Connect with Top Companies"
                        text="Build connections with leading companies seeking talented interns."
                        primary-color="#4FB148"
                        hover-color="#113F1F"
                    />
                    <FeatureCard
                        icon="fas fa-tasks"
                        title="Seamless Application Process"
                        text="Apply for internships with ease through our user-friendly platform."
                        primary-color="#4F9761"
                        hover-color="#4FB148"
                    />
                </div>
            </div>
        </section>

        <!-- ABOUT US SECTION -->

        <section id="about-us" class="py-20 px-6 bg-gray-50">
            <div
                class="container mx-auto flex flex-col-reverse md:flex-row items-center gap-12"
            >
                <!-- Left Side: Content -->
                <div class="md:w-1/2 text-center md:text-left">
                    <h2 class="text-4xl font-extrabold text-[#113F1F] mb-6">
                        About Us
                    </h2>
                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        At
                        <span class="font-bold text-[#00FFAB]"
                            >OpportuniSeek</span
                        >, we are dedicated to bridging the gap between
                        <span class="font-semibold">aspiring talents</span> and
                        top companies by offering a seamless platform for
                        discovering
                        <span class="italic"
                            >life-changing internship opportunities</span
                        >.
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed mb-8">
                        Our platform empowers individuals to
                        <span class="font-semibold">grow</span>,
                        <span class="font-semibold">learn</span>, and
                        <span class="font-semibold">succeed</span> in their
                        career journeys through tailored opportunities and
                        connections.
                    </p>
                    <div class="flex justify-center md:justify-start gap-4">
                        <a
                            href="/register"
                            class="bg-[#00FFAB] text-black px-6 py-3 rounded-full font-semibold shadow-md hover:bg-[#4F9761] transition transform hover:scale-105 duration-300"
                        >
                            Get Started
                        </a>
                        <a
                            href="/contact"
                            class="border-2 border-[#00FFAB] text-black px-6 py-3 rounded-full font-semibold hover:bg-[#4FB148] hover:text-white transition transform hover:scale-105 duration-300"
                        >
                            Contact Us
                        </a>
                    </div>
                </div>

                <!-- Right Side: Image -->
                <div class="md:w-1/2">
                    <div class="relative">
                        <img
                            src="/public/images/about-us.png"
                            alt="About Us"
                            class="w-full rounded-lg transform hover:scale-105 transition duration-500"
                        />
                        <div
                            class="absolute top-6 left-6 bg-[#4FB148] text-white px-4 py-2 rounded-full shadow-lg animate-pulse"
                        >
                            Trusted by 10,000+ Users
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="py-20 px-6 bg-white">
            <div class="container mx-auto text-center">
                <h2
                    class="text-3xl md:text-4xl font-extrabold mb-8 text-[#113F1F]"
                >
                    Hear From Our Interns
                </h2>
                <div class="flex flex-col md:flex-row gap-8 justify-center">
                    <TestimonialCard
                        text='"This platform made it so easy to find the perfect internship. I learned so much!"'
                        name="- Jane Doe"
                    />
                    <TestimonialCard
                        text='"OpportuniSeek connected me to top companies, and I got my dream internship."'
                        name="- John Smith"
                    />
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section
            class="bg-gradient-to-r from-[#00FFAB] via-[#94a3b8] to-[#cbd5e1] text-black py-20 px-6 text-center"
        >
            <div class="container mx-auto">
                <h2 class="text-3xl md:text-4xl font-extrabold">
                    Ready to Start Your Journey?
                </h2>
                <p class="mt-4 text-lg leading-relaxed">
                    Create your account today and begin exploring exciting
                    internship opportunities!
                </p>
                <a
                    href="/user/register"
                    class="mt-8 inline-block bg-[#00FFAB] text-black font-bold py-4 px-10 rounded-full shadow-lg hover:bg-[#4F9761] transform hover:scale-105 transition duration-300"
                >
                    Join Now
                </a>
            </div>
        </section>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<script setup>
import Footer from "@/Components/User/Footer.vue";
import FeatureCard from "@/Components/User/FeatureCard.vue";
import TestimonialCard from "@/Components/User/TestimonialCard.vue";
import { ref } from "vue";

const isMenuOpen = ref(false);
const active = ref("home");

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const setActive = (page) => {
    active.value = page;
    isMenuOpen.value = false; 
};
</script>

<style scoped>
nav a {
    transition: color 0.3s;
}
</style>
