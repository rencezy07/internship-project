<script setup>
import Container from '../../../Components/User/Container.vue'
import Title from '../../../Components/User/Title.vue'
import InputField from '../../../Components/User/InputField.vue'
import PrimaryBtn from '../../../Components/User/PrimaryBtn.vue'
import ErrorMessages from '../../../Components/User/ErrorMessages.vue'

import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    token: String,
    email: String,
})

const form = useForm({
    token: props.token,
    email: props.email,
    password:"",
    password_confirmation:"",

});

const submit = () => {
    form.post(route("password.update"), {
        onFinish: () => form.reset('password', "password_confirmation")
    })
}

</script>


<template>
    <Head title="- Reset Password"/>
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Enter your new password</Title>
        </div>

        <!-- Error Messages -->
        <ErrorMessages :errors="form.errors"/>
        <form @submit.prevent="submit" class="space-y-7">
            <InputField label="Email" icon="envelope" v-model="form.email"/>
            <InputField label="Password" type="password" icon="key" v-model="form.password"/>
            <InputField label="ConfirmPassword" type="password" icon="key" v-model="form.password_confirmation"/>
            <PrimaryBtn :disabled="form.processing">Reset Password</PrimaryBtn>
        </form>
    </Container>
</template>