<script setup>
// import { switchTheme } from "../theme"; darkmode
import NavLink from "../Components/User/NavLink.vue";
import Footer from "../Components/User/Footer.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user);

const show = ref(false)

</script>

<template>
    <!-- overlay -->
    <div v-show="show" @click="show = false" class="fixed inset-0 z-40"></div>
    <header class="bg-slate-800 text-white">
        <nav
            class="p-6 mx-auto max-w-screen-lg flex items-center justify-between"
        >
            <NavLink routeName="home" componentName="Home">Homers</NavLink>
            <div class="flex items-center">
                <!-- AUTH -->
                <div v-if="user" class="relative">
                    <div
                    @click="show = !show"
                        class="flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-slate-700 cursor-pointer"
                        :class="{'bg-slate-700' : show}"
                    >
                    <p>{{ user.name }}</p>
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
                        routeName="register"
                        componentName="Auth/User/Register"
                        type="user"
                        >Registeruser</NavLink
                    >
                    <NavLink routeName="login" componentName="Auth/User/Login"
                    type="user"
                        >Login</NavLink
                    >
                </div>
            </div>
        </nav>
    </header>

    <main class="p-6">
        <p>This is the Main Layout</p>
        <slot />
        <div v-if="!user">
            <Footer />
        </div>
    </main>
</template>
