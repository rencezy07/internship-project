<script setup>
import NavLink from "../Components/User/NavLink.vue";
import Footer from "../Components/User/Footer.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const page = usePage();
const merchant = computed(() => page.props.auth.merchant);

const show = ref(false);
</script>
<template>
    <div class="bg-white min-h-screen">
        <!-- Header Section -->
        <div v-show="show" @click="show = false" class="fixed inset-0 z-40"></div>
    <header class="bg-slate-800 text-white">
        <nav
            class="p-6 mx-auto max-w-screen-lg flex items-center justify-between"
        >
            <NavLink routeName="merchant" componentName="merchant">Home</NavLink>
            <div class="flex items-center">
                <!-- AUTH -->
                <div v-if="user" class="relative">
                    <div
                    @click="show = !show"
                        class="flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-slate-700 cursor-pointer"
                        :class="{'bg-slate-700' : show}"
                    >
                    <p>{{ merchant.name }}</p>
                    <i class="fa-solid fa-angle-down"></i>
                    </div>
                <!-- USER DROP DOWN -->
                <div 
                v-show="show"
                @click="show=false"
                class="absolute z-50 top-16 right-0 bg-slate-800 text-white rounded-lg border-slate-300 border overflow-hidden w-40">
                <Link class="block w-full px-6 py-3 hover:bg-slate-700 text-left" :href="route('dashboard')">Dashboard</Link>
                <Link 
                :href="route('profile.info')"
                as="button" class="block w-full px-6 py-3 hover:bg-slate-700 text-left">Profile</Link>
                <Link 
                :href="route('logout')"
                method="post"
                as="button" class="block w-full px-6 py-3 hover:bg-slate-700 text-left">Logout</Link>
                </div>

                </div>
                <!-- GUEST -->
                <div v-else>
                    <NavLink
                        routeName="merchant.register"
                        componentName="Auth/Merchant/Register"
                        >Registers</NavLink
                    >
                    <NavLink routeName="merchant.login" componentName="Auth/Merchant/Login"
                        >Logins</NavLink
                    >

                    
                </div>
            </div>
        </nav>
        <!-- <p>This is the Merchant Layout</p>
        <slot /> -->
    </header>

        <!-- Main Content Section -->
        <section
            class="bg-cover bg-center text-white py-16"
            style="background-image: url('https://via.placeholder.com/1920x1080')"
        >
            <div class="max-w-7xl mx-auto text-center">
                <h2 class="text-4xl font-bold">
                    Grow Your Business with TriptoCARAGA
                </h2>
                <p class="mt-4 text-lg">
                    Your Gateway to Thriving Tourism in the Heart of Caraga!
                </p>
                <button
                    class="mt-6 px-8 py-3 bg-white text-green-500 font-bold rounded-md hover:bg-green-200 transition duration-300"
                >
                    Get Started
                </button>
            </div>
        </section>

        <!-- Why TriptoCARAGA Section -->
        <section class="py-16 bg-white text-center">
            <h2 class="text-3xl font-bold text-green-500">Why TriptoCARAGA?</h2>
            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-8"
            >
                <div class="p-6 border rounded-md shadow-lg">
                    <h3 class="text-xl font-semibold">Boost Visibility</h3>
                    <p class="mt-2">
                        Showcase your business to thousands of tourists
                        exploring Caraga.
                    </p>
                </div>
                <div class="p-6 border rounded-md shadow-lg">
                    <h3 class="text-xl font-semibold">Easy Management</h3>
                    <p class="mt-2">
                        Simply booking, availability, and customer interactions
                        in one platform.
                    </p>
                </div>
                <div class="p-6 border rounded-md shadow-lg">
                    <h3 class="text-xl font-semibold">Grow Revenue</h3>
                    <p class="mt-2">
                        Attract more customers and increase bookings
                        effortlessly.
                    </p>
                </div>
                <div class="p-6 border rounded-md shadow-lg">
                    <h3 class="text-xl font-semibold">Connect with Tourists</h3>
                    <p class="mt-2">
                        Build trust through reviews, ratings, and personalized
                        experiences.
                    </p>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="py-16 bg-gray-100">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-green-500">FAQs</h2>
                <div class="mt-6">
                    <div
                        v-for="(faq, index) in faqs"
                        :key="index"
                        class="border-b py-4"
                    >
                        <button
                            class="w-full text-left text-lg text-green-500 font-semibold"
                            @click="toggleFaq(index)"
                        >
                            {{ faq.question }}
                        </button>
                        <div v-if="faq.isOpen" class="mt-2 text-gray-600">
                            {{ faq.answer }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Ready to get Started Section -->
        <section
            class="py-16 bg-cover bg-center text-white text-center"
            style="background-image: url('https://via.placeholder.com/1920x1080')"
        >
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold">Ready to get started?</h2>
                <button
                    class="mt-6 px-8 py-3 bg-white text-green-500 font-bold rounded-md hover:bg-green-200 transition duration-300"
                >
                    Get Started
                </button>
            </div>
        </section>
        <!-- Footer Section -->
        <Footer />
    </div>
</template>


<script>
export default {
    data() {
        return {
            faqs: [
                {
                    question:
                        "What kind of product/service can we sell on TriptoCARAGA?",
                    answer: "You can sell anything related to tourism, such as travel experiences, hotels, restaurants, etc.",
                    isOpen: false,
                },
                {
                    question: "How can I become a merchant of TriptoCARAGA?",
                    answer: "You can sign up through our Merchant Sign-Up page.",
                    isOpen: false,
                },
                {
                    question:
                        "What should I do if I encounter problems during registration?",
                    answer: "Please contact our support team for assistance.",
                    isOpen: false,
                },
            ],
        };
    },
    methods: {
        toggleFaq(index) {
            this.faqs[index].isOpen = !this.faqs[index].isOpen;
        },
    },
};
</script>

<style scoped>
.bg-lime-400 {
    background-color: #ccff33;
}

button {
    outline: none;
}
</style>

