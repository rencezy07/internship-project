<script setup>
import Container from '../../../Components/User/Container.vue'
import Title from '../../../Components/User/Title.vue'
import TextLink from '../../../Components/User/TextLink.vue'
import InputField from '../../../Components/User/InputField.vue'
import PrimaryBtn from '../../../Components/User/PrimaryBtn.vue'
import ErrorMessages from '../../../Components/User/ErrorMessages.vue'
import Checkbox from '../../../Components/User/Checkbox.vue'
import SessionMessages from '../../../Components/User/SessionMessages.vue'

import { useForm } from '@inertiajs/vue3'

const form = useForm({
    email:"",
    password:"",
    remember: null,
});

defineProps({
    status:String,
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password')
    })
}

</script>


<template>
    <Head title="- Login"/>
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Login to your account</Title>
            <p>Need an account? <TextLink routeName="register" label="Register" /></p>
        </div>

        <!-- Error Messages -->
        <ErrorMessages :errors="form.errors"/>
        <SessionMessages :status="status" />
        <form @submit.prevent="submit" class="space-y-7">
            <InputField label="Email" icon="envelope" v-model="form.email"/>
            <InputField label="Password" type="password" icon="key" v-model="form.password"/>
            <PrimaryBtn :disabled="form.processing">Login</PrimaryBtn>
            <div class="flex items-center justify-between">
            <Checkbox name="remember" v-model="form.remember">Remember me</Checkbox>
            <TextLink routeName="password.request" label="Forgot Password?" />
            </div>
        </form>
    </Container>
</template>